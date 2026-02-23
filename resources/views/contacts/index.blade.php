<x-app-layout>
<div class="p-6 max-w-5xl mx-auto">

<h1 class="text-2xl font-bold mb-4">Contactos</h1>

<div class="bg-white shadow rounded p-4 mb-4">
<p class="text-sm text-gray-500">
{{ $contacts->count() }} / {{ $plan->max_contacts }} usados
</p>
</div>

@if($contacts->count() < $plan->max_contacts)
<form method="POST" action="{{ route('contacts.store') }}" class="bg-white p-4 shadow rounded mb-6">
@csrf
<input name="name" placeholder="Nombre" class="border p-2 w-full mb-2">
<button class="bg-blue-600 text-white px-4 py-2 rounded">Agregar</button>
</form>
@endif

<div class="bg-white shadow rounded">
@foreach($contacts as $contact)
<div class="p-3 border-b">{{ $contact->name }}</div>
@endforeach
</div>

</div>
</x-app-layout>