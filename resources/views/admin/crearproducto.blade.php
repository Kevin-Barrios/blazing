<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear Producto - Blazing Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #ffffffff;
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      color: #212529;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card-custom {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      padding: 30px 25px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      max-width: 650px;
      margin: 50px auto;
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

    .btn-success {
      border-radius: 10px;
      font-weight: 700;
      padding: 12px 25px;
      transition: background-color 0.3s ease;
    }
    .btn-success:hover {
      background-color: #146c43;
    }

    .form-control, .form-select {
      border-radius: 8px;
      border: 1.5px solid #ced4da;
      padding: 0.5rem 1rem;
    }
    .form-control:focus, .form-select:focus {
      border-color: #6366f1;
      box-shadow: 0 0 5px rgba(99,102,241,0.5);
      outline: none;
    }

    h2 {
      font-weight: 700;
      font-size: 1.75rem;
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .alert ul {
      margin-bottom: 0;
      padding-left: 20px;
    }

  </style>
</head>
<body class="text-dark">

  <nav class="navbar navbar-expand-lg" style="background-color: #6c757d;">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold text-white" href="#">Blazing Store</a>
      <div class="d-flex">
        <a href="{{ route('productos.index') }}" class="btn btn-dashboard">Volver al Inventario</a>
      </div>
    </div>
  </nav>

  <div class="card-custom">
    <h2>Crear Nuevo Producto</h2>

    @if ($errors->any())
      <div class="alert alert-danger rounded-3 shadow-sm">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" novalidate>
      @csrf

      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del producto <span class="text-danger">*</span></label>
        <input 
          type="text" 
          class="form-control @error('nombre') is-invalid @enderror" 
          id="nombre" 
          name="nombre" 
          value="{{ old('nombre') }}" 
          required>
        @error('nombre')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
        <textarea 
          class="form-control @error('descripcion') is-invalid @enderror" 
          id="descripcion" 
          name="descripcion" 
          rows="4"
          required>{{ old('descripcion') }}</textarea>
        @error('descripcion')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label for="precio" class="form-label">Precio <span class="text-danger">*</span></label>
          <input 
            type="number" 
            class="form-control @error('precio') is-invalid @enderror" 
            id="precio" 
            name="precio" 
            step="0.01" 
            min="0"
            value="{{ old('precio') }}" 
            required>
          @error('precio')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-6">
          <label for="talla" class="form-label">Talla</label>
          <select class="form-select @error('talla') is-invalid @enderror" id="talla" name="talla">
            <option value="" selected>Seleccione una talla</option>
            @foreach(['XS', 'S', 'M', 'L', 'XL'] as $size)
              <option value="{{ $size }}" {{ old('talla') == $size ? 'selected' : '' }}>{{ $size }}</option>
            @endforeach
          </select>
          @error('talla')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <!-- Campo Categoría -->
      <div class="mb-3">
        <label for="id_categoria" class="form-label">Categoría <span class="text-danger">*</span></label>
        <select 
          class="form-select @error('id_categoria') is-invalid @enderror" 
          id="id_categoria" 
          name="id_categoria" 
          required>
          <option value="" disabled selected>Seleccione una categoría</option>
          @foreach($categorias as $categoria)
            <option value="{{ $categoria->id_categoria }}" {{ old('id_categoria') == $categoria->id_categoria ? 'selected' : '' }}>
              {{ $categoria->nombre }}
            </option>
          @endforeach
        </select>
        @error('id_categoria')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="cantidad" class="form-label">Cantidad en inventario</label>
        <input
          type="number"
          class="form-control @error('cantidad') is-invalid @enderror"
          id="cantidad"
          name="cantidad"
          min="0"
          value="{{ old('cantidad') }}">
        @error('cantidad')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="imagen" class="form-label">Imagen del producto <span class="text-danger">*</span></label>
        <input 
          type="file" 
          class="form-control @error('imagen') is-invalid @enderror" 
          id="imagen" 
          name="imagen" 
          accept="image/*" 
          required>
        @error('imagen')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-success w-100 py-2">Guardar Producto</button>
    </form>
  </div>

</body>
</html>


