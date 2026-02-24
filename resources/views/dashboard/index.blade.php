<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">
            Dashboard
        </h2>
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- RESUMEN SUPERIOR --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- PLAN ACTUAL --}}
            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-sm text-gray-500">Plan actual</p>
                <h3 class="text-xl font-bold">{{ $plan->name }}</h3>
                <p class="text-sm text-gray-400 mt-2">
                    Activo hasta {{ $subscription->ends_at->format('d/m/Y') }}
                </p>
            </div>

            {{-- CONTACTOS --}}
            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-sm text-gray-500">Contactos usados</p>
                <h3 class="text-2xl font-bold">
                    {{ $contactsCount }} / {{ $plan->max_contacts }}
                </h3>

                <div class="w-full bg-gray-200 h-2 mt-3 rounded">
                    <div class="bg-blue-500 h-2 rounded"
                         style="width: {{ ($contactsCount / $plan->max_contacts) * 100 }}%">
                    </div>
                </div>
            </div>

            {{-- CAMPAÑAS --}}
            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-sm text-gray-500">Mensajes usadas</p>
                <h3 class="text-2xl font-bold">
                    {{ $messagesCount }} / {{ $plan->max_messages }}
                </h3>

                <div class="w-full bg-gray-200 h-2 mt-3 rounded">
                    <div class="bg-green-500 h-2 rounded"
                         style="width: {{ ($messagesCount / $plan->max_messages) * 100 }}%">
                    </div>
                </div>
            </div>

        </div>

        {{-- ACCIONES RÁPIDAS --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-4">Acciones rápidas</h3>

            <div class="grid md:grid-cols-4 gap-4">

                <a href="{{ route('contacts.index') }}"
                   class="bg-blue-50 hover:bg-blue-100 p-4 rounded-lg text-center">
                    <p class="font-semibold">Agregar contacto</p>
                </a>

                <a href="{{ route('messages.index') }}"
                   class="bg-green-50 hover:bg-green-100 p-4 rounded-lg text-center">
                    <p class="font-semibold">Crear Mensaje</p>
                </a>

                <a href="{{ route('plans.index') }}"
                   class="bg-purple-50 hover:bg-purple-100 p-4 rounded-lg text-center">
                    <p class="font-semibold">Cambiar plan</p>
                </a>

                <a href="{{ route('subscription.show') }}"
                   class="bg-gray-50 hover:bg-gray-100 p-4 rounded-lg text-center">
                    <p class="font-semibold">Ver facturación</p>
                </a>

            </div>
        </div>

        {{-- INFORMACIÓN DEL PLAN --}}
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-4">Límites de tu plan</h3>

            <ul class="space-y-2 text-gray-600">
                <li>✔ Máx. destinatarios: {{ $plan->max_contacts }}</li>
                <li>✔ Máx. mensajes: {{ $plan->max_messages }}</li>
                <li>✔ Frecuencia envíos: cada {{ $plan->send_frequency_days }} días</li>
                <li>✔ Tamaño máximo archivo: {{ $plan->max_upload_mb }} MB</li>
            </ul>
        </div>

    </div>
</x-app-layout>