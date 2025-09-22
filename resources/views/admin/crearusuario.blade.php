<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear Usuario</title>
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

    .btn-success {
      background-color: #198754;
      border: none;
      transition: background-color 0.3s ease;
    }

    .btn-success:hover {
      background-color: #146c43;
    }

    .form-control {
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
      <h3 class="text-center mb-4">Crear Usuario</h3>

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
        </div>
      @endif

      <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="correo" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Contraseña</label>
          <input type="password" name="password_usu" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Rol</label>
          <select name="id_rol" class="form-select" required>
            @foreach ($roles as $rol)
              <option value="{{ $rol->id_rol }}" {{ $rol->id_rol == 2 ? 'selected' : '' }}>
                {{ $rol->nombre }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="d-flex justify-content-end gap-2">
          <button type="submit" class="btn btn-success">Guardar</button>
          <a href="{{ route('usuarios.index') }}" class="btn btn-dashboard">Cancelar</a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>


