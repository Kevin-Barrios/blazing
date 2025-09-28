<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Historial de Compras</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet" />

  <style>
    body {
      background-color: #f3f4f6;
      font-family: 'Inter', sans-serif;
      margin: 0;
      display: flex;
      min-height: 100vh;
      overflow-x: hidden;
      color: #212529;
    }

    /* Sidebar */
    #sidebar {
      width: 240px;
      background: linear-gradient(180deg, #343a40, #495057);
      color: white;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      padding-top: 70px;
      box-shadow: 3px 0 8px rgba(0,0,0,0.15);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    #sidebar h2 {
      font-size: 1.1rem;
      font-weight: 700;
      text-transform: uppercase;
      padding: 10px 20px;
      margin: 0;
      color: #ced4da;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    #sidebar .nav-link {
      color: #f8f9fa;
      font-weight: 600;
      padding: 14px 20px;
      transition: all 0.2s ease-in-out;
      display: flex;
      align-items: center;
      gap: 12px;
      border-left: 4px solid transparent;
    }
    #sidebar .nav-link:hover {
      background-color: rgba(255,255,255,0.1);
      border-left: 4px solid #0d6efd;
      color: #ffffff;
    }
    #sidebar .nav-link.active {
      background-color: #0d6efd;
      border-left: 4px solid #0d6efd;
      color: #fff;
    }

    /* Contenido */
    .content {
      margin-left: 240px;
      padding: 80px 2rem 2rem 2rem;
      flex-grow: 1;
    }

    /* Navbar superior */
    nav.navbar-top {
      position: fixed;
      top: 0;
      left: 240px;
      right: 0;
      height: 56px;
      background-color: #fff;
      border-bottom: 1px solid #dee2e6;
      z-index: 1030;
      padding: 0 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-weight: 600;
      color: #212529;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    /* Cards */
    .card-custom {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .custom-orange {
      background-color: #ffb74d !important;
      color: #212529 !important;
    }
    table {
      background-color: white;
    }
    table tbody tr:hover {
      background-color: rgba(255, 193, 7, 0.2);
      cursor: pointer;
    }

    /* Logout */
    .logout-form {
      padding: 20px;
    }
    .logout-form button {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-weight: 600;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <nav id="sidebar">
    <div>
      <h2>Gestión</h2>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a href="{{ url('admin/dashboard') }}" class="nav-link">
            <i class="bi bi-speedometer2"></i>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.historial') }}" class="nav-link active">
            <i class="bi bi-clock-history"></i>
            Historial de Compras
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('productos.index') }}" class="nav-link">
            <i class="bi bi-box-seam"></i>
            Productos
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('usuarios.index') }}" class="nav-link">
            <i class="bi bi-people-fill"></i>
            Usuarios
          </a>
        </li>
      </ul>
    </div>

    <div class="logout-form">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">
          <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
        </button>
      </form>
    </div>
  </nav>

  <!-- Navbar superior -->
  <nav class="navbar-top">
    <span>🔥 Blaz!ng Store - Panel de Administración</span>
    @if(session()->has('usuario_nombre'))
      <span class="badge bg-primary">{{ session('usuario_nombre') }} ({{ session('usuario_rol') }})</span>
    @endif
  </nav>

  <!-- Contenido -->
  <div class="content">
    <div class="container">
      <div class="card card-custom">
        <h3 class="text-center mb-4">Historial de Compras</h3>

        @forelse ($compras as $compra)
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between custom-orange">
                <div>
                    <strong>Compra #{{ $compra->id_compra }}</strong><br>
                    <small>Fecha: {{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y H:i') }}</small>
                </div>
                <div class="text-end">
                    <strong>Usuario:</strong> {{ $compra->usuario->nombre ?? 'Desconocido' }}
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="custom-orange">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio Unitario</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($compra->detalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->producto->nombre ?? 'Producto Eliminado' }}</td>
                                    <td class="text-center">{{ $detalle->cantidad }}</td>
                                    <td class="text-end">${{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td class="text-end fw-bold">${{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <p class="mb-0"><strong>IVA:</strong> ${{ number_format($compra->iva_total, 2) }}</p>
                    <p class="fs-5"><strong>Total:</strong> ${{ number_format($compra->total, 2) }}</p>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            No se encontraron compras registradas.
        </div>
    @endforelse

      </div>
    </div>
  </div>

</body>
</html>
