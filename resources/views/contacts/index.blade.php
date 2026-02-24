<x-app-layout>
<div class="p-6 max-w-6xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Contactos</h1>

    {{-- Resumen del plan --}}
    <div class="bg-white shadow rounded p-4 mb-6 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500">
                {{ $contacts->total() }} / {{ $plan->max_contacts }} usados
            </p>
            <div class="w-64 bg-gray-200 rounded-full h-2 mt-2">
                <div 
                    class="bg-blue-600 h-2 rounded-full"
                    style="width: {{ ($contacts->total() / $plan->max_contacts) * 100 }}%">
                </div>
            </div>
        </div>
        <span class="text-xs text-gray-400">
            Plan actual
        </span>
    </div>

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Formulario --}}
    @if($contacts->total() < $plan->max_contacts)
    <form method="POST" action="{{ route('contacts.store') }}"
          class="bg-white p-6 shadow rounded mb-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium">Nombre</label>
                <input name="name" value="{{ old('name') }}"
                       class="border p-2 w-full rounded mt-1"
                       required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-medium">Email</label>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       class="border p-2 w-full rounded mt-1">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-medium">Teléfono</label>
                <input name="phone"
                       value="{{ old('phone') }}"
                       class="border p-2 w-full rounded mt-1">
                @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-medium">Canal Preferido</label>
                <select name="preferred_channel"
                        class="border p-2 w-full rounded mt-1">
                    <option value="email">Email</option>
                    <option value="sms">SMS</option>
                    <option value="whatsapp">WhatsApp</option>
                </select>
            </div>
        </div>

        <div class="mt-4 text-right">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
                Agregar contacto
            </button>
        </div>
    </form>
    @endif

    {{-- Tabla --}}
    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Teléfono</th>
                    <th class="p-3">Canal</th>
                    <th class="p-3">Fecha</th>
                    <th class="p-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-3 font-medium">{{ $contact->name }}</td>
                        <td class="p-3">{{ $contact->email ?? '-' }}</td>
                        <td class="p-3">{{ $contact->phone ?? '-' }}</td>
                        <td class="p-3 capitalize">
                            {{ $contact->preferred_channel ?? 'email' }}
                        </td>
                        <td class="p-3 text-gray-500">
                            {{ $contact->created_at->format('d/m/Y') }}
                        </td>
                        <td class="p-3 text-right">
                            <form method="POST"
                                  action="{{ route('contacts.destroy', $contact) }}"
                                  onsubmit="return confirm('¿Eliminar contacto?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline text-xs">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">
                            No hay contactos aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    <div class="mt-4">
        {{ $contacts->links() }}
    </div>

</div>
</x-app-layout>