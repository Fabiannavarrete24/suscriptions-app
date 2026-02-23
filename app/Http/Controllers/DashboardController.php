<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $subscription = $user->subscriptions()
            ->with('plan')
            ->where('active', 1)
            ->first();

        if (!$subscription) {
            return redirect()->route('plans.index');
        }

        $plan = $subscription->plan;

        // Uso actual
        $contactsCount = $user->contacts()->count();
        $campaignsCount = $user->campaigns()->count();

        return view('dashboard.index', compact(
            'subscription',
            'plan',
            'contactsCount',
            'campaignsCount'
        ));
    }
}