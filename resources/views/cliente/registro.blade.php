<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro de Usuario</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <link rel="website icon" type="png" href="imagenes/fondoinkflame6.png"/>

  <style>
    * {
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
      background-color: rgba(0, 0, 0, 0.65); 
      color: white;
    }

    .container-fluid {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .row.flex-fill {
      flex: 1;
    }

    .left-panel {
      background-color: rgba(255, 255, 255, 0.8);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }

    .right-panel {
      background-image: url('imagenes/fondo\ inicio\ y\ registro.jpg');
      background-size: cover;
      background-position: center;
    }

    .login-container {
      width: 100%;
      max-width: 400px;
      position: relative;
      text-align: center;
    }

    .form-group {
      margin-bottom: 20px;
      text-align: left;
      color: black;
      position: relative;
    }

    input[type="email"],
    input[type="password"],
    input[type="id_rol"],
    input[type="text"] {
      width: 100%;
      background-color: transparent;
      padding: 12px 40px 12px 12px;
      border-radius: 30px;
      border: 1px solid #4444;
      font-size: 16px;
    }

    input[type="email"]::placeholder,
    input[type="password"]::placeholder,
    input[type="text"]::placeholder {
        color: black;
    }

    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="text"]:focus {
      background-color: transparent;
      outline: none;
      box-shadow: none;
      border-color: black;
    }

    .btn {
      background-color: #959595;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 18px;
      cursor: pointer;
      border-radius: 30px;
      width: 100%;
    }

    .btn:hover {
      background-color: #ff8500;
    }

    .custom-title {
      font-size: 28px;
      font-weight: bold;
      text-align: center;
      color: black;
    }

    .logo-wrapper {
      text-align: left;
    }

    .logo {
      max-height: 120px;
    }

    footer {
      background-color: #959595;
      color: white;
      padding: 15px 0;
      text-align: center;
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100vw;
      margin: 0;
      z-index: 9999;
    }

    @media (max-width: 767px) {
      .right-panel {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div class="container-fluid">
    <div class="row flex-fill h-100">
      <div class="col-md-4 left-panel">
        <div class="login-container">
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif

          <form action="{{ route('registro.guardar') }}" method="POST">
            @csrf
            <div class="logo-wrapper mb-3">
              <img src="{{ asset('imagenes/fondoinkflame6.png') }}" alt="logo" class="logo">
            </div>
            <h1 class="custom-title mb-4">Registrarse</h1>

            <div class="form-group">
              <label for="nombre">Nombre y Apellido</label>
              <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre" value="{{ old('nombre') }}">
            </div>

            <div class="form-group">
              <label for="correo">Correo Electrónico</label>
              <input type="email" name="correo" class="form-control" id="correo" placeholder="Correo Electrónico" value="{{ old('correo') }}">
            </div>

            <div class="form-group">
              <label for="id_rol">Roles</label>
              <select name="id_rol" id="id_rol" class="form-control">
                <option value="">Selecciona un rol</option>
                @foreach($roles as $rol)
                  <option value="{{ $rol->id_rol }}" {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>
                    {{ $rol->nombre }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="password_usu">Contraseña</label>
              <input type="password" name="contrasena" class="form-control" id="password_usu" placeholder="Contraseña">
            </div>

            <div class="form-group">
              <label for="password_confirmation">Confirmar Contraseña</label>
              <input type="password" name="contrasena_confirmation" class="form-control" id="password_confirmation" placeholder="Confirma tu contraseña">
            </div>

            <button type="submit" class="btn btn-danger btn-block mt-3">Registrarse</button>
          </form>
        </div>
      </div>

      <div class="col-md-8 right-panel d-none d-md-block"></div>
    </div>
  </div>

  <footer class="footer">
    <div class="container text-center">
      <p class="mb-0">&copy; 2025 Ink Flame. Todos los derechos reservados.</p>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>








