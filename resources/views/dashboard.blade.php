@if(auth()->user()->hasActiveSubscription())
    <div class="bg-blue-100 text-blue-800 p-4 rounded mb-4">
        Estás usando el plan:
        <strong>{{ auth()->user()->plan->name }}</strong>
    </div>
@else
    <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4">
        Aún no tienes un plan activo.
        <a href="{{ route('plans.index') }}" class="underline">Elegir plan</a>
    </div>
@endif