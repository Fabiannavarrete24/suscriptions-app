<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">
            Mensajes
        </h2>
    </x-slot>
    <div class="max-w-6xl mx-auto py-8 px-4">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Nuevo Mensaje
                </h1>
                <p class="text-sm text-gray-500">
                    Plan: <span class="font-semibold text-indigo-600">{{ $plan->name }}</span>
                </p>
            </div>

            <a href="{{ route('messages.index') }}"
                class="text-gray-500 hover:text-gray-700 text-sm">
                ← Volver
            </a>
        </div>

        {{-- ERRORES --}}
        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
            <ul class="list-disc ml-5 text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- INFORMACIÓN DEL PLAN --}}
            <div class="space-y-6">

                <div class="bg-white shadow rounded-xl p-6">
                    <p class="text-sm text-gray-500">Contactos permitidos por envío</p>
                    <h3 class="text-2xl font-bold">
                        Máx {{ $plan->max_contacts }}
                    </h3>
                </div>

                <div class="bg-white shadow rounded-xl p-6">
                    <p class="text-sm text-gray-500">Mensajes usados</p>
                    <h3 class="text-2xl font-bold">
                        {{ $messagesCount }} / {{ $plan->max_campaigns }}
                    </h3>
                </div>

                <div class="bg-white shadow rounded-xl p-6">
                    <p class="text-sm text-gray-500">Subida máxima</p>
                    <h3 class="text-xl font-semibold">
                        {{ $plan->max_upload_mb ?? 0 }} MB
                    </h3>
                </div>

            </div>

            {{-- FORMULARIO --}}
            <div class="md:col-span-2 bg-white shadow rounded-2xl p-8">

                <form method="POST"
                    action="{{ route('messages.store') }}"
                    enctype="multipart/form-data"
                    class="space-y-6">

                    @csrf

                    {{-- TÍTULO --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Título del mensaje
                        </label>
                        <input type="text"
                            name="title"
                            value="{{ old('title') }}"
                            class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500"
                            required>
                    </div>

                    {{-- CONTENIDO --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Contenido
                        </label>
                        <textarea name="message"
                            rows="5"
                            class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500"
                            required>{{ old('message') }}</textarea>
                    </div>

                    {{-- CANAL --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Canal de envío
                        </label>

                        <select name="channel"
                            class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500"
                            required>

                            <option value="">Seleccionar canal</option>

                            @if($plan->allow_email)
                            <option value="email">Email</option>
                            @endif

                            @if($plan->allow_sms)
                            <option value="sms">SMS</option>
                            @endif

                            @if($plan->allow_whatsapp)
                            <option value="whatsapp">WhatsApp</option>
                            @endif

                        </select>
                    </div>

                    {{-- CONTACTOS --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Seleccionar contactos (máx {{ $plan->max_contacts }})
                        </label>

                        <div class="border rounded-xl p-4 max-h-48 overflow-y-auto space-y-2">

                            @forelse($contacts as $contact)
                            <label class="flex items-center gap-2">
                                <input type="checkbox"
                                    name="contacts[]"
                                    value="{{ $contact->id }}"
                                    class="contact-checkbox">
                                {{ $contact->name }}
                            </label>
                            @empty
                            <p class="text-sm text-gray-400">
                                No tienes contactos registrados.
                            </p>
                            @endforelse

                        </div>

                        <p class="text-xs text-gray-500 mt-2">
                            Seleccionados:
                            <span id="selected-count">0</span>
                        </p>
                    </div>

                    {{-- MEDIA --}}
                    @if($plan->max_upload_mb > 0)
                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Imagen o video (opcional)
                        </label>
                        <input type="file"
                            name="media"
                            class="w-full border rounded-xl px-4 py-2">
                    </div>
                    @endif

                    {{-- BOTÓN --}}
                    <div class="pt-4">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl shadow transition w-full">
                            Crear Mensaje
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- SCRIPT CONTADOR --}}
    <script>
        const checkboxes = document.querySelectorAll('.contact-checkbox');
        const maxContacts = {
            {
                $plan - > max_contacts
            }
        };
        const counter = document.getElementById('selected-count');

        checkboxes.forEach(box => {
            box.addEventListener('change', () => {
                let selected = document.querySelectorAll('.contact-checkbox:checked').length;

                if (selected > maxContacts) {
                    box.checked = false;
                    alert("Has alcanzado el máximo permitido por tu plan.");
                    return;
                }

                counter.textContent = selected;
            });
        });
    </script>
</x-app-layout>