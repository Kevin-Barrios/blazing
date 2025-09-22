<header>
    <div class="logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('imagenes/fondoinkflame4.png') }}" alt="Blazing">
        </a>
    </div>

    <nav>
            <ul class="main-menu">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('categorias.hombre') }}">Hombre</a></li>
                <li><a href="{{ route('categorias.mujer') }}">Mujer</a></li>
                <li><a href="{{ route('categorias.nino') }}">Niño</a></li>
                <li><a href="{{ route('categorias.novedades') }}">Novedades</a></li>

    </ul>
    </nav>

    <div>
        <a href="{{ route('login') }}" class="login-btn">Iniciar Sesión</a>
    </div>
</header>
