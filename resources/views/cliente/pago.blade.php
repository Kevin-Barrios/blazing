<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago - Blazing Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('{{ asset('imagenes/Fondo body pagina blazing.svg') }}');
            margin: 0;
            padding: 0;
            text-align: center;
        }

        header {
            background-color: #959595;
            color: white;
            padding: 10px 0;
        }

        header h1 {
            margin: 10;
            font-size: 32px;
        }

        .icono-container {
            position: absolute;
            top: 30px; 
            right: 15px; 
            display: flex; 
            gap: 10px; 
        }

        nav a {
            margin: 0 15px;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .payment-container {
            padding: 20px;
            max-width: 600px;
            margin: 40px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn {
            background-color: #fbc02d;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .btn:hover {
            background-color: #f57f17;
        }

        .payment-methods img {
            width: 50px;
            margin: 0 12px 20px;
            cursor: pointer;
        }

        footer {
            background-color: #959595;
            color: white;
            padding: 1px 0;
            position: static;
            width: 100%;
            bottom: 0;
            margin-top: 280px;
        }
    </style>
</head>
<body>

<header>
    <h1>Pago</h1>
    <div class="icono-container">
        <nav>
            <a href="{{ route('inicio') }}">
                <i class="bi bi-house" style="font-size: 28px; color: white;"></i>
            </a>

            <a href="{{ route('carrito') }}">
                <i class="bi bi-cart" style="font-size: 28px; color: white;"></i>
            </a>
        </nav>
    </div>
</header>

<main>
    <div class="payment-container">
        <h2>Detalles del Pago</h2>
        <!--<form method="POST" action="{{ route('pago.procesar') }}">-->
        <form method="POST" action="#">
            @csrf
            <input type="text" name="cardNumber" placeholder="Número de tarjeta" required>
            <input type="text" name="cardHolder" placeholder="Titular de la tarjeta" required>
            <input type="number" name="amount" value="450.00" readonly>

            <div class="payment-methods">
                <h3>Selecciona un método de pago:</h3>
                <input type="radio" name="paymentMethod" value="Nequi" required> <img src="{{ asset('imagenes/nequi.jpg') }}">
                <input type="radio" name="paymentMethod" value="Visa"> <img src="{{ asset('imagenes/visa.png') }}">
                <input type="radio" name="paymentMethod" value="PayPal"> <img src="{{ asset('imagenes/paypal.png') }}">
                <input type="radio" name="paymentMethod" value="Bancolombia"> <img src="{{ asset('imagenes/bancolombia.jpg') }}">
            </div>

            <button type="submit" class="btn">Realizar Pago</button>
        </form>
    </div>
</main>

<footer>
    <p>&copy; 2025 Blazing Store. Todos los derechos reservados.</p>
</footer>

</body>
</html>


