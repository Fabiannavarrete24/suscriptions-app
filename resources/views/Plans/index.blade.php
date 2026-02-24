<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Planes disponibles
        </h2>
    </x-slot>

    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

        @foreach($plans as $plan)

        <div class="bg-white shadow rounded p-6">
            <h3 class="text-lg font-bold mb-2">{{ $plan->name }}</h3>

            <p class="text-gray-600 mb-2">
                ${{ $plan->price_monthly }} / mensual
            </p>

            <p class="text-sm text-gray-500 mb-4">
                Contactos: {{ $plan->max_contacts }} <br>
                Mensajes: {{ $plan->max_messages }}
            </p>

            {{-- VALIDAR SI YA TIENE ESTE PLAN --}}
            @if(
            $currentSubscription &&
            $currentSubscription->plan_id == $plan->id &&
            $currentSubscription->ends_at->isFuture()
            )
            <div class="bg-green-100 text-green-700 p-3 rounded">
                ✅ Ya tienes este plan activo hasta
                {{ $currentSubscription->ends_at->format('d/m/Y') }}
            </div>
            @else
            <form method="POST" action="{{ route('subscribe', $plan->id) }}">
                @csrf

                <label class="block text-sm mb-1">Facturación</label>

                <select name="billing_cycle" class="border p-2 mb-3 w-full">
                    <option value="monthly">Mensual</option>
                    <option value="yearly">Anual (PSE)</option>
                </select>

                <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded w-full">
                    Suscribirme
                </button>
            </form>
            @endif
        </div>

        @endforeach
        @if(isset($balance))
        <p class="text-green-600">Saldo a favor: ${{ $balance }}</p>
        @endif
    </div>
</x-app-layout>