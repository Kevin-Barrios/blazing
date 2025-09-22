<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Producto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #ffffffff;
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      color: #212529;
    }

    .card-custom {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .btn-dashboard {
      background-color: #6c757d;
      color: white;
      border: none;
      transition: background-color 0.3s ease;
    }

    .btn-dashboard:hover {
      background-color: #5a6268;
      color: white;
    }

    .btn-crear {
      background-color: #6c757d;
      color: white;
      border: none;
      transition: background-color 0.3s ease;
    }

    .btn-crear:hover {
      background-color: #5a6268;
      color: white;
    }

    .btn-success {
      background-color: #198754;
      border: none;
      transition: background-color 0.3s ease;
    }

    .btn-success:hover {
      background-color: #146c43;
    }

    .form-control, .form-select {
      border-radius: 8px;
    }
  </style>
</head>
<body class="text-dark">

  <nav class="navbar navbar-expand-lg" style="background-color: #6c757d;">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold text-white" href="#">Blazing Store</a>
      <div class="d-flex">
        <a href="{{ url('admin/dashboard') }}" class="btn btn-dashboard">Volver al Dashboard</a>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="card card-custom mx-auto" style="max-width:600px;">
      <h3 class="text-center mb-4">Editar Producto</h3>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('productos.update', $producto->id_producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre del producto</label>
          <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $producto->nombre }}" required>
        </div>

        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ $producto->descripcion }}</textarea>
        </div>

        <div class="mb-3">
          <label for="precio" class="form-label">Precio</label>
          <input type="number" class="form-control" id="precio" name="precio" step="0.01" value="{{ $producto->precio }}" required>
        </div>

        <div class="mb-3">
          <label for="talla" class="form-label">Talla</label>
          <select class="form-select" id="talla" name="talla">
            <option value="">Seleccione una talla</option>
            <option value="XS" {{ $producto->talla == 'XS' ? 'selected' : '' }}>XS</option>
            <option value="S" {{ $producto->talla == 'S' ? 'selected' : '' }}>S</option>
            <option value="M" {{ $producto->talla == 'M' ? 'selected' : '' }}>M</option>
            <option value="L" {{ $producto->talla == 'L' ? 'selected' : '' }}>L</option>
            <option value="XL" {{ $producto->talla == 'XL' ? 'selected' : '' }}>XL</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="cantidad" class="form-label">Cantidad</label>
          <input type="number" name="cantidad" class="form-control" value="{{ old('cantidad', $producto->cantidad ?? '') }}">
        </div>

        <!-- Nuevo select de categorías -->
        <div class="mb-3">
          <label for="categoria_id" class="form-label">Categoría <span class="text-danger">*</span></label>
          <select class="form-select @error('categoria_id') is-invalid @enderror" id="categoria_id" name="categoria_id" required>
            <option value="">Seleccione una categoría</option>
            @foreach ($categorias as $categoria)
              <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                {{ $categoria->nombre }}
              </option>
            @endforeach
          </select>
          @error('categoria_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <!-- Fin select de categorías -->

        <div class="mb-3">
          <label for="imagen" class="form-label">Imagen del producto (opcional)</label>
          <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
          <div class="mt-2">
            <img src="{{ asset('imagenes/' . $producto->imagen) }}" width="80">
          </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-success">Actualizar Producto</button>
          <a href="{{ route('productos.index') }}" class="btn btn-crear">Cancelar</a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>


