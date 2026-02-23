<x-app-layout>
    <div class="p-6 max-w-6xl mx-auto">

        <h1 class="text-2xl font-bold mb-6">Campañas</h1>

        <form method="POST" enctype="multipart/form-data"
            class="bg-white p-6 rounded shadow mb-6">
            @csrf

            <input name="title" placeholder="Título" class="border p-2 w-full mb-3">

            <textarea name="message" placeholder="Mensaje"
                class="border p-2 w-full mb-3"></textarea>

            <select name="channel" class="border p-2 mb-3">
                <option value="email">Correo</option>
                <option value="sms">SMS</option>
                <option value="whatsapp">WhatsApp</option>
            </select>

            <input type="file" name="media" class="mb-3">

            @isset($plan)
            <p class="text-sm text-gray-500 mb-3">
                Máx permitido: {{ $plan->max_upload_mb }}MB
            </p>
            @endisset

            <button class="bg-green-600 text-white px-5 py-2 rounded">
                Guardar campaña
            </button>

        </form>

        @forelse($campaigns as $campaign)
        <div class="bg-white shadow rounded p-4 mb-2">
            {{ $campaign->title }}
        </div>
        @empty
        <div class="bg-gray-100 p-4 rounded text-gray-500">
            No hay campañas aún.
        </div>
        @endforelse

    </div>
</x-app-layout>