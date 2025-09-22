<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Blazing Store - Dashboard</title>
  <link rel="icon" href="/favicon.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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
    #content {
      margin-left: 240px;
      flex-grow: 1;
      padding: 100px 2rem 2rem 2rem;
      min-height: 100vh;
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

    /* Tarjetas */
    .card-stat {
      border-radius: 12px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.08);
      padding: 20px;
      background: #fff;
      transition: transform 0.2s ease-in-out;
    }
    .card-stat:hover {
      transform: translateY(-3px);
    }
    .card-stat h3 {
      font-size: 1.2rem;
      font-weight: 700;
    }
    .card-stat .icon {
      font-size: 2rem;
      opacity: 0.8;
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
  <nav id="sidebar" aria-label="Barra lateral de navegación">
    <div>
      <h2>Gestión</h2>
      <ul class="nav flex-column">
        <li class="nav-item">
          <a href="{{ route('compras.create') }}" class="nav-link">
            <i class="bi bi-plus-circle"></i>
            Registrar Compra
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.historial') }}" class="nav-link">
            <i class="bi bi-clock-history"></i>
            Historial de Compras
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('productos.index') }}" class="nav-link">
            <i class="bi bi-box-seam"></i>
            Ver Productos
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

  <!-- Navbar -->
  <nav class="navbar-top">
    <span>🔥 Blaz!ng Store - Panel de Administración</span>
    @if(session()->has('usuario_nombre'))
      <span class="badge bg-primary">{{ session('usuario_nombre') }} ({{ session('usuario_rol') }})</span>
    @endif
  </nav>

  <!-- Contenido -->
  <main id="content" role="main" tabindex="-1">
    <h1 class="mb-5">Dashboard de Administración</h1>

    <!-- Estadísticas -->
    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="card-stat text-center">
          <div class="icon text-primary"><i class="bi bi-cart-check"></i></div>
          <h3>{{ $totalCompras ?? 0 }}</h3>
          <p class="mb-0">Compras realizadas</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-stat text-center">
          <div class="icon text-success"><i class="bi bi-currency-dollar"></i></div>
          <h3>${{ number_format($ingresosTotales ?? 0, 2) }}</h3>
          <p class="mb-0">Ingresos totales</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-stat text-center">
          <div class="icon text-warning"><i class="bi bi-box-seam"></i></div>
          <h3>{{ $productos ?? 0 }}</h3>
          <p class="mb-0">Productos activos</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card-stat text-center">
          <div class="icon text-info"><i class="bi bi-people"></i></div>
          <h3>{{ $usuarios ?? 0 }}</h3>
          <p class="mb-0">Usuarios</p>
        </div>
      </div>
    </div>

    <!-- Top productos -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-light fw-bold">Top Productos con Más Stock</div>
      <div class="card-body">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Producto</th>
              <th class="text-end">Cantidad</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($productosConCantidad ?? [] as $producto)
              <tr>
                <td>{{ $producto->nombre }}</td>
                <td class="text-end">{{ $producto->cantidad }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="2" class="text-center">No hay productos activos</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Últimas compras -->
    <div class="card shadow-sm">
      <div class="card-header bg-light fw-bold">Últimas Compras</div>
      <div class="card-body">
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Usuario</th>
              <th>Fecha</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($ultimasCompras ?? [] as $compra)
              <tr>
                <td>{{ $compra->id_compra }}</td>
                <td>{{ $compra->usuario->nombre ?? 'Desconocido' }}</td>
                <td>{{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y H:i') }}</td>
                <td>${{ number_format($compra->total, 2) }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center">No hay compras recientes</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
