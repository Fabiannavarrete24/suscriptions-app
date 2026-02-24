<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">
            Mensajes
        </h2>
    </x-slot>
<div class="max-w-7xl mx-auto py-8 px-4">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Gestión de Mensajes
            </h1>
            <p class="text-sm text-gray-500">
                Plan actual: 
                <span class="font-semibold text-indigo-600">
                    {{ $plan->name }}
                </span>
                | Máx contactos por envío: {{ $plan->max_contacts }}
            </p>
        </div>

        <a href="{{ route('messages.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl shadow transition">
            + Nuevo Mensaje
        </a>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabla --}}
    <div class="bg-white shadow rounded-2xl overflow-hidden">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-6 py-4 text-left">Título</th>
                    <th class="px-6 py-4 text-left">Canal</th>
                    <th class="px-6 py-4 text-left">Contactos</th>
                    <th class="px-6 py-4 text-left">Fecha</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">

                @forelse($messages as $message)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $message->title }}
                        </td>

                        <td class="px-6 py-4">
                            @if($message->channel == 'email')
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                                    Email
                                </span>
                            @elseif($message->channel == 'sms')
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                    SMS
                                </span>
                            @elseif($message->channel == 'whatsapp')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    WhatsApp
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            {{ $message->contacts_count }}
                        </td>

                        <td class="px-6 py-4 text-gray-500">
                            {{ $message->created_at->format('d M Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                            No has creado mensajes todavía.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>
</x-app-layout>