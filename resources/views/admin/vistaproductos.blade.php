<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inventario de Productos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #ffffffff;
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
    .card-custom {
      background: rgba(255, 255, 255, 0.9); 
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    thead.custom-orange {
      background-color: #ffb74d !important; 
      color: #212529 !important; 
    }
    tbody tr {
      transition: background-color 0.3s ease;
    }
    tbody tr:hover {
      background-color: rgba(255, 193, 7, 0.2);
      cursor: pointer;
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
    table {
      background-color: white;
    }
    .btn-eliminar {
      background-color: #dc3545;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 4px 10px;
    }
    .btn-eliminar:hover {
      background-color: #c82333;
    }
    .btn-editar {
      background-color: #6c757d;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 4px 10px;
    }
    .btn-editar:hover {
      background-color: #5a6268;
    }
  </style>
</head>
<body class="text-dark">
  <nav class="navbar navbar-expand-lg" style="background-color: #6c757d;">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold text-white" href="#">Blazing Store</a>
      <div class="d-flex">
        <a href="/admin/dashboard" class="btn btn-dashboard">Volver al Dashboard</a>
      </div>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="card card-custom">
      <h3 class="text-center mb-4">Lista de productos</h3>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <div class="d-flex justify-content-between mb-3 flex-wrap gap-3">
        <div>
          <a href="{{ route('productos.crear') }}" class="btn btn-crear">Crear Producto</a>
        </div>
        <form class="d-flex" role="search" onsubmit="return false;">
          <input id="searchInput" class="form-control" type="search" placeholder="Buscar producto..." aria-label="Buscar" />
        </form>
      </div>

      <div class="table-responsive">
        <table id="productosTable" class="table table-hover align-middle">
          <thead class="custom-orange">
            <tr>
              <th>ID</th>
              <th>Producto</th>
              <th>Descripción</th>
              <th>Imagen</th>
              <th>Categoría</th> 
              <th>Talla</th>
              <th>Cantidad</th>
              <th>Precio</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($productos as $producto)
            <tr>
              <td>{{ $producto->id_producto }}</td>
              <td>{{ $producto->nombre }}</td>
              <td>{{ $producto->descripcion }}</td>
              <td>
                <img src="{{ asset('imagenes/' . $producto->imagen) }}" width="80" alt="Producto {{ $producto->nombre }}">
              </td>
              <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td> 
              <td>{{ $producto->talla }}</td>
              <td>{{ $producto->cantidad }}</td>
              <td>${{ number_format($producto->precio, 2) }}</td>
              <td>
                <div class="d-flex btn-group-sm gap-2">
                  <a href="{{ route('productos.editar', $producto->id_producto) }}" class="btn btn-editar">Editar</a>
                  <button 
                    class="btn btn-eliminar" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalEliminar{{ $producto->id_producto }}"
                  >
                    Eliminar
                  </button>
                </div>

                <!-- Modal de confirmación -->
                <div class="modal fade" id="modalEliminar{{ $producto->id_producto }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Confirmar Eliminación</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body text-dark">
                        ¿Estás seguro de eliminar el producto <strong>{{ $producto->nombre }}</strong>?
                      </div>
                      <div class="modal-footer">
                        <form action="{{ route('productos.destroy', $producto->id_producto) }}" method="POST" class="m-0 p-0">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-eliminar">Sí, eliminar</button>
                        </form>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                      </div>
                    </div>
                  </div>
                </div>

              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <footer class="text-center mt-4 text-muted">
        Blazing Store © {{ date('Y') }}
      </footer>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  document.getElementById('searchInput').addEventListener('input', function() {
    const query = this.value.trim().toLowerCase();
    const rows = document.querySelectorAll('#productosTable tbody tr');

    rows.forEach(row => {
      const id = row.cells[0]?.textContent.trim().toLowerCase();  
      const nombre = row.cells[1]?.textContent.trim().toLowerCase();
      const descripcion = row.cells[2]?.textContent.trim().toLowerCase();
      const categoria = row.cells[4]?.textContent.trim().toLowerCase(); 

      if (
        id.includes(query) ||
        nombre.includes(query) ||
        descripcion.includes(query) ||
        categoria.includes(query)
      ) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });
  </script>
</body>
</html>
