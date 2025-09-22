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
      background-color: #fff;
      color: #333;
    }

    .navbar {
      background-color: #fff;
      border-bottom: 1px solid #eee;
      padding: 1rem 2rem;
    }

    .usuario-box {
      font-weight: 600;
      color: #555;
      background-color: #f8f9fa;
      padding: 6px 14px;
      border-radius: 20px;
      box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
    }

    .btn-primary {
      background-color: #d35400;
      border: none;
      font-weight: 600;
      padding: 10px 20px;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #b34700;
    }
  </style>
</head>
<body>

  {{-- NAVBAR --}}
  <nav class="navbar d-flex justify-content-between align-items-center">
    <a href="{{ route('inicio') }}" class="navbar-brand">
      <img src="{{ asset('imagenes/Blaz!ng Store logo B Negra2.svg') }}" alt="Logo" height="60" />
    </a>
    <div>
      @if(session()->has('usuario_nombre'))
          <span class="usuario-box">Bienvenido, {{ session('usuario_nombre') }} ({{ session('usuario_rol') }})</span>
          <a href="{{ route('perfil.editar') }}" class="btn btn-sm btn-warning ms-2">Editar Perfil</a>
          <a href="{{ route('logout') }}" class="btn btn-sm btn-danger ms-2">Cerrar Sesión</a>
      @endif
    </div>
  </nav>

  {{-- CONTENIDO --}}
  <div class="container my-5">
    <h2 class="mb-4">Editar Perfil</h2>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('perfil.actualizar') }}" method="POST">
      @csrf

      <input type="hidden" name="id_usuario" value="{{ $usuario->id_usuario }}">

      <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ $usuario->nombre }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Correo</label>
        <input type="email" name="correo" class="form-control" value="{{ $usuario->correo }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Contraseña (dejar vacío si no quieres cambiarla)</label>
        <input type="password" name="password_usu" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Confirmar Contraseña</label>
        <input type="password" name="password_usu_confirmation" class="form-control">
      </div>

      <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
  </div>

  {{-- FOOTER --}}
  <footer class="text-center py-4 bg-light">
    <img src="{{ asset('imagenes/Blaz!ng Store logo B Negra.svg') }}" alt="Logo" height="50" class="mb-3" />
    <p>Somos un E-commerce de venta de ropa personalizada.</p>
    <p>Manejamos gran variedad de diseños para cada uno de nuestros productos.</p>
    <small class="text-muted">&copy; 2025 Blazing Store. Todos los derechos reservados.</small>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
