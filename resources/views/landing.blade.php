@if(auth()->check())
    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}">Admin</a>
    @else
        <a href="{{ route('user.dashboard') }}">Panel</a>
    @endif
@else
    <a href="{{ route('login') }}">Login</a>
@endif