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

    .btn-dashboard, .btn-crear, .btn-agregar {
      background-color: #6c757d;
      color: white;
      border: none;
      transition: background-color 0.3s ease;
    }

    .btn-dashboard:hover,
    .btn-crear:hover,
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

        <div id="productos-container">
          <div class="row g-2 mb-3 producto-item">
            <div class="col-md-5">
              <select name="productos[0][id_producto]" class="form-select" required>
                <option value="">Seleccione un producto</option>
                @foreach ($productos as $producto)
                  <option value="{{ $producto->id_producto }}">{{ $producto->nombre }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2">
              <input type="number" name="productos[0][cantidad]" class="form-control" placeholder="Cantidad" required>
            </div>
            <div class="col-md-3">
              <input type="number" step="0.01" name="productos[0][precio_unitario]" class="form-control" placeholder="Precio Unitario" required>
            </div>
            <div class="col-md-2 text-center">
              <span class="remove-row">Borrar fila</span>
            </div>
          </div>
        </div>

        <button type="button" class="btn btn-agregar mb-3" id="add-producto">Agregar producto</button>

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
          <select name="productos[${index}][id_producto]" class="form-select" required>
            <option value="">Seleccione un producto</option>
            @foreach ($productos as $producto)
              <option value="{{ $producto->id_producto }}">{{ $producto->nombre }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <input type="number" name="productos[${index}][cantidad]" class="form-control" placeholder="Cantidad" required>
        </div>
        <div class="col-md-3">
          <input type="number" step="0.01" name="productos[${index}][precio_unitario]" class="form-control" placeholder="Precio Unitario" required>
        </div>
        <div class="col-md-2 text-center">
          <span class="remove-row">🗑️</span>
        </div>
      `;
      container.appendChild(newRow);
      index++;
    });

    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('remove-row')) {
        e.target.closest('.producto-item').remove();
      }
    });
  </script>
</body>
</html>
