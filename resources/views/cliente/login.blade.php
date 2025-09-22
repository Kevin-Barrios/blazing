<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio de Sesión - Blazing Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="icon" type="image/png" href="{{ asset('imagenes/fondoinkflame6.png') }}" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            margin: 0;
            background-color: rgba(0, 0, 0, 0.65);
            color: white;
            overflow: hidden;
        }

        .container-fluid {
            height: 100%;
        }

        .row {
            height: 100%;
            display: flex;
            flex-wrap: no-wrap;
        }

        .left-panel {
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
            height: 100%;
        }

        .right-panel {
            background-image: url('{{ asset("imagenes/fondo inicio y registro.jpg") }}');
            background-size: cover;
            background-position: center;
            height: 100%;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            position: relative;
            text-align: center;
            height: 100%;
            margin-top: 80px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
            color: black;
            position: relative;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            background-color: transparent;
            padding: 12px 40px 12px 12px;
            border-radius: 30px;
            border: 1px solid #4444;
            font-size: 16px;
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: black;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
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

        .custom-link,
        .custom-text,
        .custom-title {
            color: black;
        }

        .custom-title {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
        }

        footer {
            background-color: #959595;
            color: white;
            padding: 15px 1px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        @media (max-width: 767px) {
            .right-panel {
                display: none;
            }
        }

        .logo-wrapper {
            text-align: left;
        }

        .logo {
            max-height: 120px;
        }

        .iconocorreo,
        .iconocontraseña {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            pointer-events: none;
            color: black;
        }

    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row h-100">
            <div class="col-md-4 left-panel">
                <div class="login-container">

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf
                        <div class="logo-wrapper mb-3">
                            <img src="{{ asset('imagenes/Fondo_new__Blazing.-Mesa-de-trabajo-1-01.png') }}" alt="logo" class="logo">
                        </div>
                        <h1 class="custom-title mb-4">Iniciar Sesión</h1>

                        <div class="form-group">
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico"
                                value="{{ old('correo') }}" />
                            @error('correo') 
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <svg xmlns="http://www.w3.org/2000/svg" class="iconocorreo" width="20" height="20" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" />
                            @error('password') 
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <svg xmlns="http://www.w3.org/2000/svg" class="iconocontraseña" width="20" height="20" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 0a4 4 0 0 1 4 4v2.05a2.5 2.5 0 0 1 2 2.45v5a2.5 2.5 0 0 1-2.5 2.5h-7A2.5 2.5 0 0 1 2 13.5v-5a2.5 2.5 0 0 1 2-2.45V4a4 4 0 0 1 4-4m0 1a3 3 0 0 0-3 3v2h6V4a3 3 0 0 0-3-3" />
                            </svg>
                        </div>

                        <!-- Enlace para recuperar contraseña--
                        <div class="text-center mt-2 mb-2">
                            <a href="{{ route('password.request') }}" class="custom-link">¿Olvidaste tu Contraseña?</a>
                        </div> -->

                        <!-- Botón de iniciar sesión -->
                        <button type="submit" class="btn btn-danger mt-2" style="color: black;">Iniciar Sesión</button>

                        <!-- Enlace para registrarse -->
                        <div class="text-center mt-3">
                            <p class="custom-text">¿No Tienes Cuenta?</p>
                        </div>

                        <a href="{{ url('registro') }}" class="btn btn-danger mt-2" style="color: black;">Registrarse</a>
                    </form>
                </div>
            </div>

            <div class="col-md-8 right-panel"></div>
        </div>
    </div>

    <footer>
        <p class="mb-0">&copy; 2025 Blazing. Todos los derechos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
