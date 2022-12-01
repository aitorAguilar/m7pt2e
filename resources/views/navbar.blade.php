<!-- Navigation -->
<nav>
    @if (Auth::check()) 
        <b>Has fet login com a: {{Auth::user()->name }}</b>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        </form><br>
    @endif
    <a href="{{ route('home') }}">Inici</a>
    &nbsp;&nbsp;&nbsp;
    <a href="{{ route('llibre_list') }}">Llibres</a>
    &nbsp;&nbsp;&nbsp;
    <a href="{{ route('autor_list') }}">Autors</a>
    
    @if (!Auth::check()) 
            &nbsp;&nbsp;&nbsp;
            <a href="{{ route('login') }}">Login</a>
            &nbsp;&nbsp;&nbsp;
            <a href="{{ route('register') }}">Register</a>
    @endif
</nav>
