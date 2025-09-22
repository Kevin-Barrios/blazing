<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
            background-image: url("{{ asset('imagenes/Fondo body pagina blazing.svg') }}");
            background-size: cover;
            background-position: center;
            text-align: center;
        }

        .header {
            background-color: #2271b3;
            padding: 1%;
        }

        main {
            flex: 1;
        }

        .recover-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 30px auto;
        }

        .custom-title {
            color: black;
            font-size: 22px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .btn {
            background-color: #2271b3;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }

        .btn:hover {
            background-color: #da0000;
        }

        footer {
            background-color: #2271b3;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('imagenes/Blaz!ng Store logo B Blanca.svg') }}" alt="Logo Blazing Store" style="max-height: 90px;">
    </div>

    <main class="container mt-5">
        <div class="recover-container">
            <form action="{{ route('recuperar.enviar') }}" method="POST">
                @csrf
                <div class="text-center mt-3">
                    <label class="custom-title">Recuperar Contraseña</label>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="correo electrónico" required>
                </div>

                <button class="btn mt-5">Recuperar</button>
            </form>
        </div>
    </main>

    <footer>
        <p class="mb-0">© 2024 Blazing Store. Todos los derechos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


