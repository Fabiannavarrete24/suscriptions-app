<x-app-layout>
<div class="p-6 max-w-5xl mx-auto">

<h1 class="text-2xl font-bold mb-6">Facturación</h1>

<table class="w-full bg-white shadow rounded">
<tr class="border-b">
<th class="p-3 text-left">Fecha</th>
<th>Monto</th>
<th>Método</th>
<th>Estado</th>
</tr>

@foreach($invoices as $invoice)
<tr class="border-b">
<td class="p-3">{{ $invoice->created_at }}</td>
<td>${{ $invoice->amount }}</td>
<td>{{ $invoice->payment_method }}</td>
<td>{{ $invoice->status }}</td>
</tr>
@endforeach

</table>

</div>
</x-app-layout>