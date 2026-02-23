<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Mi Suscripción</h2>
    </x-slot>

    <div class="p-6">

        <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-bold">{{ $subscription->plan->name }}</h3>

            <p>Inicio: {{ $subscription->starts_at->format('d/m/Y') }}</p>
            <p>Vence: {{ $subscription->ends_at->format('d/m/Y') }}</p>
            <p>Contactos permitidos: {{ $subscription->plan->max_contacts }}</p>
            <p>Campañas permitidas: {{ $subscription->plan->max_campaigns }}</p>
        </div>

    </div>
</x-app-layout>