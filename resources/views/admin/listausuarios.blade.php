<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      color: #212529;
    }

    /* Sidebar */
    .sidebar {
      width: 220px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #343a40;
      padding-top: 20px;
    }

    .sidebar a {
      display: block;
      padding: 12px;
      color: #fff;
      text-decoration: none;
      font-weight: 500;
    }

    .sidebar a:hover {
      background-color: #495057;
    }

    .content {
      margin-left: 230px;
      padding: 20px;
    }

    .card-custom {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      margin-top: 20px;
    }

    /* Tabla de usuarios */
    .table thead {
      background-color: #ffb74d;
      color: #212529;
    }

    .table tbody tr:hover {
      background-color: rgba(255, 193, 7, 0.15);
    }

    /* Botones */
    .btn-crear {
      background-color: #ff9800;
      color: white;
      border: none;
      padding: 6px 15px;
      border-radius: 8px;
      transition: 0.3s;
    }

    .btn-crear:hover {
      background-color: #fb8c00;
      color: white;
    }

    .btn-editar {
      background-color: #6c757d;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 5px 12px;
      transition: 0.3s;
    }

    .btn-editar:hover {
      background-color: #5a6268;
      color: white;
    }

    .btn-eliminar {
      background-color: #dc3545;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 5px 12px;
      transition: 0.3s;
    }

    .btn-eliminar:hover {
      background-color: #c82333;
      color: white;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center text-white mb-4">Blazing Store</h4>
    <a href="{{ url('admin/dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.historial') }}">Historial de Compras</a>
    <a href="{{ route('productos.index') }}">Gestión de Productos</a>
    <a href="{{ url('admin/usuarios') }}">Usuarios</a>
    <a href="{{ route('logout') }}">Cerrar Sesión</a>
  </div>

  <!-- Contenido -->
  <div class="content">
    <div class="container">
      <div class="card card-custom">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="mb-0">Usuarios</h2>
          <a href="{{ route('usuarios.create') }}" class="btn-crear">+ Crear Usuario</a>
        </div>

        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
          <table class="table table-hover align-middle text-center">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($usuarios as $usuario)
                <tr>
                  <td>{{ $usuario->id_usuario }}</td>
                  <td>{{ $usuario->nombre }}</td>
                  <td>{{ $usuario->correo }}</td>
                  <td>
                    <span class="badge bg-secondary">{{ $usuario->rol->nombre ?? 'Sin rol' }}</span>
                  </td>
                  <td>
                    <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}" class="btn-editar btn-sm me-1">Editar</a>
                    <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-eliminar btn-sm">Eliminar</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
