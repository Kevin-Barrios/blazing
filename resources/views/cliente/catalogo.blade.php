<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Catálogo - Blazing Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fafafa;
      color: #333;
      background-image: url('{{ asset("imagenes/Fondo body pagina blazing.svg") }}');
      background-size: cover; 
      background-position: center;  
      background-repeat: no-repeat;
      min-height: 100vh;
      margin: 0;
      display: flex;
      overflow-x: hidden;
      flex-direction: column;
    }

    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 250px;
      background-color: #e67e22;
      color: white;
      padding-top: 60px;
      transition: transform 0.3s ease;
      overflow-y: auto;
      z-index: 1000;
    }
    #sidebar.collapsed {
      transform: translateX(-100%);
    }
    #sidebar h3 {
      padding-left: 20px;
      margin-bottom: 1rem;
      font-weight: 700;
      border-bottom: 1px solid rgba(255,255,255,0.3);
      padding-bottom: 0.5rem;
    }
    #sidebar ul {
      list-style: none;
      padding-left: 0;
    }
    #sidebar ul li {
      padding: 12px 20px;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }
    #sidebar ul li:hover {
      background-color: rgba(255,255,255,0.2);
    }
    #sidebar ul li a {
      color: white;
      text-decoration: none;
      display: block;
      font-weight: 600;
    }

    #sidebarToggle {
      position: fixed;
      top: 15px;
      left: 15px;
      background-color: #e67e22;
      border: none;
      color: white;
      padding: 10px 12px;
      border-radius: 4px;
      cursor: pointer;
      z-index: 1100;
      font-weight: 700;
      box-shadow: 0 2px 5px rgba(0,0,0,0.3);
      transition: background-color 0.3s ease;
    }
    #sidebarToggle:hover {
      background-color: #cf711b;
    }

    nav.navbar {
      position: fixed;
      top: 0;
      left: 250px;
      right: 0;
      height: 50px;
      background-color: #fff;
      border-bottom: 1px solid #eee;
      display: flex;
      align-items: center;
      padding: 0 1rem;
      transition: left 0.3s ease;
      z-index: 900;
    }
    nav.navbar.expanded {
      left: 0;
    }
    nav.navbar .navbar-brand {
      display: flex;
      align-items: center;
    }
    nav.navbar .navbar-brand img {
      height: 40px;
      object-fit: contain;
    }
    nav.navbar .scrolling-text-container {
      flex-grow: 1;
      overflow: hidden;
      white-space: nowrap;
      position: relative;
      margin-left: 1rem;
    }
    nav.navbar .scrolling-text {
      display: inline-block;
      padding-left: 100%;
      animation: scroll-left 15s linear infinite;
      font-weight: 600;
      color: #e67e22;
      font-size: 1rem;
    }
    @keyframes scroll-left {
      0% {
        transform: translateX(0%);
      }
      100% {
        transform: translateX(-100%);
      }
    }

    #content {
      margin-left: 250px;
      margin-top: 50px; 
      margin-bottom: 80px; 
      padding: 2rem 1.5rem;
      flex-grow: 1;
      transition: margin-left 0.3s ease;
      width: 100%;
    }
    #content.expanded {
      margin-left: 0;
    }

    .product-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      background-color: #fff;
      transition: box-shadow 0.3s ease;
      cursor: pointer;
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .product-card:hover {
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      transform: translateY(-5px);
    }
    .product-img {
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
      height: 280px;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    .product-card:hover .product-img {
      transform: scale(1.05);
    }
    .product-info {
      padding: 15px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .product-title {
      font-weight: 700;
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
      color: #222;
    }
    .product-price {
      font-size: 1.2rem;
      font-weight: 700;
      color: #e67e22;
      margin-bottom: 0.5rem;
    }
    .btn-add-cart {
      background-color: #e67e22;
      border: none;
      color: white;
      font-weight: 600;
      padding: 10px 0;
      border-radius: 6px;
      transition: background-color 0.3s ease;
      width: 100%;
    }
    .btn-add-cart:hover {
      background-color: #cf711b;
    }

    footer {
      background-color: #222;
      color: #eee;
      padding: 1rem 1rem; 
      text-align: center;
      font-size: 0.8rem; 
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
      position: fixed;
      bottom: 0;
      left: 250px;
      right: 0;
      z-index: 800;
      transition: left 0.3s ease;
    }
    footer .footer-logo {
      margin-bottom: 0.5rem; 
    }
    footer .footer-logo img {
      height: 30px; 
      object-fit: contain;
    }
  </style>
</head>
<body>
  <button id="sidebarToggle" aria-label="Toggle sidebar">☰</button>

  <aside id="sidebar">
    <h3>Categorías</h3>
    <ul>
      <li><a href="{{ url('/catalogo?categoria=Camisas') }}">Camisas</a></li>
      <li><a href="{{ url('/catalogo?categoria=Chaquetas') }}">Chaquetas</a></li>
      <li><a href="{{ url('/catalogo?categoria=Buzos') }}">Buzos</a></li>
      <li><a href="{{ url('/catalogo?categoria=Camisetas') }}">Camisetas</a></li>
    </ul>
    <h3>Otros</h3>
    <ul>
      <li><a href="{{ url('/carrito') }}">Carrito</a></li>
      <li><a href="{{ url('/metodos-pago') }}">Métodos de pago</a></li>
      <li><a href="{{ url('/inicio') }}">Inicio</a></li>
    </ul>
  </aside>

  <nav class="navbar">
    <a href="{{ url('/inicio') }}" class="navbar-brand">
      <img src="{{ asset('imagenes/Fondo_new__Blazing.-Mesa-de-trabajo-1-01.png') }}" alt="Blazing Store Logo" />
    </a>
    <div class="scrolling-text-container">
      <div class="scrolling-text">
        ¡Bienvenido a Blazing Store! Descubre nuestras últimas colecciones y ofertas exclusivas.
      </div>
    </div>
  </nav>

  <div class="container mt-5 pt-3">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" id="alertMessage">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertMessage">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    @endif
  </div>

  <main id="content" class="container">
    <h2 class="mb-4 fw-bold">Catálogo de Productos</h2>

    <form method="GET" action="{{ url('/catalogo') }}" class="mb-4">
      @if (request('categoria'))
        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
      @endif
      <div class="row">
        <div class="col-md-4">
          <select name="talla" class="form-select" onchange="this.form.submit()">
            <option value="">-- Filtrar por talla --</option>
            @foreach ($tallas as $talla)
              <option value="{{ $talla }}" {{ request('talla') == $talla ? 'selected' : '' }}>
                {{ ucfirst($talla) }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
    </form>

    <div class="row g-4">
      @foreach ($products as $product)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
          <div class="product-card">
            <img src="{{ asset('imagenes/' . $product->imagen) }}" alt="{{ $product->nombre }}" class="product-img" />
            <div class="product-info">
              <h3 class="product-title">{{ $product->nombre }}</h3>
              <p class="product-description text-muted mb-1">{{ $product->descripcion }}</p>
              <p class="product-price mb-1">${{ number_format($product->precio, 0, ',', '.') }}</p>
              <p class="product-details mb-1">
                <strong>Talla:</strong> {{ $product->talla }} <br>
                <strong>Color:</strong> {{ $product->color }} <br>
                <strong>Cantidad disponible:</strong> {{ $product->cantidad }} <br>
                <strong>Activo:</strong> {{ $product->activo ? 'Sí' : 'No' }}
              </p>
              <button class="btn-add-cart" onclick="addToCart({{ $product->id_producto }})">Agregar al carrito</button>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </main>

  <footer>
    <div class="footer-logo">
      <img src="{{ asset('imagenes/Fondo_new__Blazing.-Mesa-de-trabajo-1-01.png') }}" alt="Blazing Store Logo" />
    </div>
    <p>© 2025 Blazing Store. Todos los derechos reservados.</p>
    <p>Somos un e-commerce de venta de ropa personalizada con diseños exclusivos.</p>
  </footer>

  <script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const content = document.getElementById('content');
    const navbar = document.querySelector('nav.navbar');
    const footer = document.querySelector('footer');

    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      content.classList.toggle('expanded');
      navbar.classList.toggle('expanded');
      footer.classList.toggle('expanded');
    });

    // Verificar si se debe limpiar el carrito después de una compra exitosa
    document.addEventListener('DOMContentLoaded', function() {
      @if(session('clear_cart'))
        // Limpiar localStorage si la compra fue exitosa
        localStorage.removeItem('cart');
        console.log('Carrito limpiado después de compra exitosa');
      @endif
    });

    const products = @json($products);
    function addToCart(productId) {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      const product = products.find(p => p.id_producto === productId);
      if (product) {
        const index = cart.findIndex(p => p.id_producto === productId);
        if (index >= 0) {
          cart[index].quantity += 1;
        } else {
          cart.push({ ...product, quantity: 1 });
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        alert('Producto agregado al carrito');
      }
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Auto cerrar alertas después de 4 segundos
    setTimeout(() => {
      const alert = document.getElementById('alertMessage');
      if (alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      }
    }, 4000);
  </script>
</body>
</html>