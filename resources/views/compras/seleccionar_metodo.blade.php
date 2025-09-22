<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Método de Pago - Blazing Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #e67e22;
            color: white;
            padding: 1rem 2rem;
        }

        header h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }

        main {
            flex: 1;
            padding: 2rem;
        }

        footer {
            background-color: #343a40;
            color: #ccc;
            padding: 1rem 2rem;
            text-align: center;
        }

        .card {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .table thead {
            background-color: #e67e22;
            color: white;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <header class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-cart-check"></i> Blazing Store</h1>
        <a href="{{ route('carrito') }}" class="btn btn-light"><i class="bi bi-arrow-left-circle"></i> Volver al carrito</a>
    </header>

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card p-4 mb-4">
                    <h2 class="mb-3"><i class="bi bi-credit-card"></i> Seleccionar Método de Pago</h2>

                    <form action="{{ route('finalizar-compra') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="metodo_pago" class="form-label fw-bold">Método de pago</label>
                            <select name="metodo_pago_id" id="metodo_pago" class="form-select" required>
                                <option value="">Seleccione un método</option>
                                @foreach($metodos as $metodo)
                                    <option value="{{ $metodo->id }}">{{ $metodo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <h4 class="mt-4"><i class="bi bi-card-list"></i> Resumen del carrito</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($cart as $item)
                                        @php $subtotal = $item['precio'] * $item['quantity']; $total += $subtotal; @endphp
                                        <tr>
                                            <td>{{ $item['nombre'] }}</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>${{ number_format($item['precio'], 0, ',', '.') }}</td>
                                            <td>${{ number_format($subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <p class="fs-5 fw-bold text-end">Total: ${{ number_format($total, 0, ',', '.') }}</p>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-check-circle"></i> Finalizar Compra</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 Blazing Store. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
