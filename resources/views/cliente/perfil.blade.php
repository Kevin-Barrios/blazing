<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Perfil - Blazing Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      background-color: #f5f5f5;
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .navbar {
      background-color: #fff;
      border-bottom: 1px solid #eee;
      padding: 1rem 2rem;
      transition: padding 0.3s ease, box-shadow 0.3s ease;
    }

    .navbar-shrink {
      padding: 0.5rem 2rem !important;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand img {
      height: 60px;
      transition: transform 0.3s ease;
    }

    .navbar-brand img:hover {
      transform: scale(1.05);
    }

    .usuario-box {
      font-weight: 600;
      color: #555;
      background-color: #f8f9fa;
      padding: 6px 14px;
      border-radius: 20px;
      box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
    }

    .btn-navbar {
      margin-left: 8px;
    }

    .perfil-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 3rem 1rem;
    }

    .perfil-card {
      background-color: #fff;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgb(0 0 0 / 0.1);
      width: 100%;
      max-width: 500px;
    }

    footer {
      text-align: center;
      padding: 1.5rem 0;
      background-color: #fff;
      border-top: 1px solid #eee;
    }

  </style>
</head>
<body>

  {{-- NAVBAR igual que inicio --}}
  <nav class="navbar d-flex justify-content-between align-items-center">
    <a href="{{ route('inicio') }}" class="navbar-brand">
      <img src="{{ asset('imagenes/Fondo_new__Blazing.-Mesa-de-trabajo-1-01.png') }}" alt="Logo" />
    </a>
    <div class="d-flex align-items-center">
      @auth
        <span class="usuario-box">Bienvenido, {{ auth()->user()->nombre }}</span>
        <a href="{{ route('usuario.perfil') }}" class="btn btn-sm btn-secondary btn-navbar">Mi Perfil</a>
        <a href="{{ route('inicio') }}" class="btn btn-sm btn-primary btn-navbar">Inicio</a>
        <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
          @csrf
          <button type="submit" class="btn btn-sm btn-danger btn-navbar">Cerrar Sesión</button>
        </form>
      @endauth
    </div>
  </nav>

  {{-- Contenedor central --}}
  <div class="perfil-container">
    <div class="perfil-card">
      <h3 class="mb-4 text-center">Editar Perfil</h3>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <form action="{{ route('usuario.perfil.actualizar') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $usuario->nombre) }}">
          @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="correo" class="form-label">Correo</label>
          <input type="email" name="correo" class="form-control" value="{{ old('correo', $usuario->correo) }}">
          @error('correo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="password_usu" class="form-label">Nueva contraseña (opcional)</label>
          <input type="password" name="password_usu" class="form-control">
          @error('password_usu') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
          <label for="password_usu_confirmation" class="form-label">Confirmar contraseña</label>
          <input type="password" name="password_usu_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>
      </form>
    </div>
  </div>

  {{-- Footer --}}
  <footer>
    <img src="{{ asset('imagenes/Fondo_new__Blazing.-Mesa-de-trabajo-1-01.png') }}" alt="Logo" height="50" class="mb-2" />
    <p class="mb-0">Somos un E-commerce de venta de ropa personalizada.</p>
    <small class="text-muted">&copy; 2025 Blazing Store. Todos los derechos reservados.</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
