<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrar Compra</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #ffffffff;
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      color: #212529;
    }

    .card-custom {
      background: rgba(255, 255, 255, 0.9);
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      margin-top: 30px;
    } 

    .navbar-custom {
      background-color: #6c757d;
    }
    .navbar-custom .navbar-brand,
    .navbar-custom .btn {
      color: white;
    }

    .btn-dashboard, .btn-agregar {
      background-color: #6c757d;
      color: white;
      border: none;
      transition: background-color 0.3s ease;
    }

    .btn-dashboard:hover,
    .btn-agregar:hover {
      background-color: #5a6268;
      color: white;
    }

    .title {
      font-weight: 700;
    }

    .remove-row {
      cursor: pointer;
      color: white;
      background-color: #dc3545;
      border-radius: 4px;
      padding: 2px 6px;
      transition: background-color 0.3s ease;
    }
    .remove-row:hover {
      background-color: #c82333;
      color: white;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">Blazing Store</a>
      <div class="d-flex">
        <a href="{{ url('admin/dashboard') }}" class="btn btn-dashboard">Volver al Panel</a>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="card card-custom">
      <h2 class="mb-4 text-center title">Registrar Nueva Compra</h2>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
          <br>
          <a href="{{ url('admin/dashboard') }}" class="btn btn-dashboard mt-2">Volver al Panel</a>
        </div>
      @endif

      <form method="POST" action="{{ route('compras.store') }}">
        @csrf

        <!-- Seleccionar Cliente -->
        <div class="mb-3">
          <label for="id_usuario" class="form-label">Cliente</label>
          <select name="id_usuario" id="id_usuario" class="form-select" required>
            <option value="">Seleccione un cliente</option>
            @foreach ($usuarios as $usuario)
              <option value="{{ $usuario->id_usuario }}">
                {{ $usuario->nombre }} ({{ $usuario->correo }})
              </option>
            @endforeach
          </select>
        </div>

        <hr>

        <!-- Productos -->
        <div id="productos-container">
          <div class="row g-2 mb-3 producto-item">
            <div class="col-md-5">
              <select name="productos[0][id_producto]" class="form-select producto-select" required>
                <option value="">Seleccione un producto</option>
                @foreach ($productos as $producto)
                  <option value="{{ $producto->id_producto }}" data-precio="{{ $producto->precio }}">
                    {{ $producto->nombre }} - ${{ number_format($producto->precio, 0, ',', '.') }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <input type="number" name="productos[0][cantidad]" class="form-control cantidad" placeholder="Cantidad" min="1" required>
            </div>
            <div class="col-md-3">
              <input type="number" step="0.01" name="productos[0][precio_unitario]" class="form-control precio-unitario" placeholder="Precio Unitario" readonly required>
            </div>
            <div class="col-md-2 text-center">
              <span class="remove-row">Borrar fila</span>
            </div>
          </div>
        </div>

        <button type="button" class="btn btn-agregar mb-3" id="add-producto">Agregar producto</button>

        <hr>


        <!-- Totales -->
        <div class="mb-3">
          <p><strong>Subtotal:</strong> $<span id="subtotal">0</span></p>
          <p><strong>IVA:</strong> $<span id="iva">0</span></p>
          <p><strong>Total:</strong> $<span id="total">0</span></p>
        </div>

        <div class="text-end">
          <button type="submit" class="btn btn-dashboard">Registrar Compra</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    let index = 1;

    document.getElementById('add-producto').addEventListener('click', () => {
      const container = document.getElementById('productos-container');
      const newRow = document.createElement('div');
      newRow.classList.add('row', 'g-2', 'mb-3', 'producto-item');
      newRow.innerHTML = `
        <div class="col-md-5">
          <select name="productos[${index}][id_producto]" class="form-select producto-select" required>
            <option value="">Seleccione un producto</option>
            @foreach ($productos as $producto)
              <option value="{{ $producto->id_producto }}" data-precio="{{ $producto->precio }}">
                {{ $producto->nombre }} - ${{ number_format($producto->precio, 0, ',', '.') }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <input type="number" name="productos[${index}][cantidad]" class="form-control cantidad" placeholder="Cantidad" min="1" required>
        </div>
        <div class="col-md-3">
          <input type="number" step="0.01" name="productos[${index}][precio_unitario]" class="form-control precio-unitario" placeholder="Precio Unitario" readonly required>
        </div>
        <div class="col-md-2 text-center">
          <span class="remove-row">Eliminar</span>
        </div>
      `;
      container.appendChild(newRow);
      index++;
    });

    // Borrar fila
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('remove-row')) {
        e.target.closest('.producto-item').remove();
        calcularTotales();
      }
    });

    // Cambiar precio automáticamente al seleccionar producto
    document.addEventListener('change', function (e) {
      if (e.target.classList.contains('producto-select')) {
        const precio = e.target.options[e.target.selectedIndex].dataset.precio;
        const inputPrecio = e.target.closest('.producto-item').querySelector('.precio-unitario');
        inputPrecio.value = precio ? precio : '';
        calcularTotales();
      }
    });

    // Recalcular al escribir cantidad
    document.addEventListener('input', function (e) {
      if (e.target.classList.contains('cantidad')) {
        calcularTotales();
      }
    });

    function calcularTotales() {
      let subtotal = 0;
      document.querySelectorAll('.producto-item').forEach(row => {
        const cantidad = parseFloat(row.querySelector('.cantidad')?.value) || 0;
        const precio = parseFloat(row.querySelector('.precio-unitario')?.value) || 0;
        subtotal += cantidad * precio;
      });
      const iva = subtotal * 0.19;
      const total = subtotal + iva;

      document.getElementById('subtotal').textContent = subtotal.toFixed(2);
      document.getElementById('iva').textContent = iva.toFixed(2);
      document.getElementById('total').textContent = total.toFixed(2);
    }
  </script>
</body>
</html>
