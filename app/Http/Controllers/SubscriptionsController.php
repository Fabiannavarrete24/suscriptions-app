<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Invoice;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    /**
     * Paso 1: Usuario selecciona plan → lo mandamos a pagar
     */
    public function store(Request $request, Plan $plan)
    {
        $request->validate([
            'billing_cycle' => 'required|in:monthly,yearly'
        ]);

        session([
            'checkout.plan_id' => $plan->id,
            'checkout.billing_cycle' => $request->billing_cycle
        ]);

        return redirect()->route('checkout', $plan);
    }

    /**
     * Paso 2: Mostrar pantalla de pago
     */
    public function checkout(Plan $plan)
    {
        $billingCycle = session('checkout.billing_cycle');

        if (!$billingCycle) {
            return redirect()->route('plans.index');
        }

        $price = $billingCycle === 'monthly'
            ? $plan->price_monthly
            : $plan->price_yearly;

        return view('subscriptions.checkout', compact('plan', 'billingCycle', 'price'));
    }

    /**
     * Paso 3: Procesar pago (simulación / luego pasarela real)
     */
    public function processPayment(Request $request, Plan $plan)
    {
        $user = $request->user();
        $billingCycle = session('checkout.billing_cycle');

        if (!$billingCycle) {
            return redirect()->route('plans.index');
        }

        /*
        |--------------------------------------------------------------------------
        | AQUÍ irá la integración real:
        | Stripe → mensual tarjeta
        | Wompi/PayU → anual PSE
        |--------------------------------------------------------------------------
        */

        // 🔴 SIMULAMOS pago aprobado
        $paymentApproved = true;

        if (!$paymentApproved) {
            return back()->with('error', 'Pago rechazado.');
        }

        // Cancelar anterior
        Subscription::where('user_id', $user->id)->update(['active' => false]);

        $start = now();
        $end = $billingCycle === 'monthly'
            ? $start->copy()->addMonth()
            : $start->copy()->addYear();

        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'billing_cycle' => $billingCycle,
            'starts_at' => $start,
            'ends_at' => $end,
            'active' => true
        ]);

        Invoice::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'payment_method' => $method,
            'status' => 'paid'
        ]);
        session()->forget('checkout');

        return redirect()->route('subscription.show')
            ->with('success', 'Pago aprobado. ¡Suscripción activada!');
    }

    /**
     * Paso 4: Mostrar resumen de suscripción activa
     */
    public function show()
    {
        $subscription = auth()->user()
            ->subscriptions()
            ->with('plan')
            ->where('active', 1)
            ->first();

        if (!$subscription) {
            return redirect()->route('plans.index');
        }

        return view('subscriptions.show', compact('subscription'));
    }
}
