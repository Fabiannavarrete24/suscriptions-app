<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Confirmar Suscripción</h2>
    </x-slot>

    <div class="p-6 max-w-xl mx-auto">

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-bold mb-4">{{ $plan->name }}</h3>

            <p><strong>Facturación:</strong>
                {{ $billingCycle === 'monthly' ? 'Mensual (Tarjeta)' : 'Anual (PSE)' }}
            </p>

            <p class="text-2xl font-bold my-4">
                ${{ number_format($price, 0) }}
            </p>

            <form method="POST" action="{{ route('payment.process', $plan) }}">
                @csrf

                {{-- luego aquí se monta Stripe Elements o botón PSE --}}
                <button class="bg-blue-600 text-white px-6 py-3 rounded w-full">
                    Pagar ahora
                </button>
            </form>
        </div>

    </div>
</x-app-layout>