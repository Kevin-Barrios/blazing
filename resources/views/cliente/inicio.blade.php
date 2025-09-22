<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Inicio - Blazing Store</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      background-color: #fff;
      color: #333;
    }

    .navbar {
      background-color: #fff;
      border-bottom: 1px solid #eee;
      padding: 1rem 2rem;
      transition: padding 0.3s ease, box-shadow 0.3s ease;
    }

    .navbar-shrink {
      padding: 0.5rem 2rem !important;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand img {
      height: 60px;
      transition: transform 0.3s ease;
    }

    .navbar-brand img:hover {
      transform: scale(1.05);
    }

    .usuario-box {
      font-weight: 600;
      color: #555;
      background-color: #f8f9fa;
      padding: 6px 14px;
      border-radius: 20px;
      box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
    }

    .icono {
      color: #555;
      transition: color 0.3s ease;
      font-size: 1.3rem;
      cursor: pointer;
    }

    .icono:hover {
      color: #d35400;
    }

    .carousel-item {
      height: 65vh;
      min-height: 400px;
      background-size: cover;
      background-position: center;
      position: absolute;
      width: 100%;
      opacity: 1;
      transition: transform 1s ease-in-out;
    }

    .carousel-item.active {
      opacity: 1;
      position: relative;
    }

    .carousel-caption {
      bottom: 20%;
      text-align: left;
      background: rgba(0,0,0,0.5);
      padding: 2rem;
      border-radius: 10px;
      max-width: 600px;
    }

    .btn-primary {
      background-color: #d35400;
      border: none;
      font-weight: 600;
      padding: 10px 20px;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #b34700;
    }

    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 6px 15px rgb(0 0 0 / 0.15);
    }

    .card-img-top {
      height: 220px;
      object-fit: cover;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }

    .opacity-0 {
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.6s ease;
    }

    .fade-in {
      opacity: 1 !important;
      transform: translateY(0) !important;
    }

    #scrollTopBtn {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background: #d35400;
      color: white;
      border: none;
      border-radius: 50%;
      width: 45px;
      height: 45px;
      font-size: 24px;
      display: none;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      z-index: 999;
    }

    #scrollTopBtn:hover {
      background-color: #b34700;
    }
  </style>
</head>
<body>
  {{-- NAVBAR --}}
  <nav class="navbar d-flex justify-content-between align-items-center">
    <a href="{{ route('inicio') }}" class="navbar-brand">
      <img src="{{ asset('imagenes/Fondo_new__Blazing.-Mesa-de-trabajo-1-01.png') }}" alt="Logo" height="60" />
    </a>
    <div>
      {{-- Mostrar el nombre del usuario si está autenticado --}}
      @auth
        <span class="usuario-box">Bienvenido, {{ auth()->user()->nombre }}</span>

        {{-- Botón de cerrar sesión (POST) --}}
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
          @csrf
          <button type="submit" class="btn btn-sm btn-danger ms-2">Cerrar Sesión</button>
        </form>

        <a href="{{ route('usuario.perfil') }}" class="btn btn-sm btn-secondary ms-2">Mi Perfil</a>
      @endauth
    </div>
  </nav>

  {{-- CAROUSEL PRINCIPAL --}}
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-indicators">
      @foreach($heroSlides as $index => $slide)
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}"
          class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"
          aria-label="Slide {{ $index + 1 }}"></button>
      @endforeach
    </div>
    <div class="carousel-inner">
      @foreach($heroSlides as $index => $slide)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}"
          style="background-image: url('{{ asset('imagenes/' . $slide->imagen) }}')">
          <div class="carousel-caption d-none d-md-block">
            <h1>{{ $slide->titulo }}</h1>
            <p>{{ $slide->descripcion }}</p>
            @if($slide->url)
              <a href="{{ $slide->url }}" class="btn btn-primary">Comprar ahora</a>
            @endif
          </div>
        </div>
      @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
  </div>

  {{-- PRODUCTOS --}}
  <section class="container my-5">
    <h2 class="mb-4">PRODUCTOS </h2>
    <div class="row g-4">
      @foreach ($productosBD as $producto)
        <div class="col-6 col-md-3">
          <div class="card h-100 opacity-0">
            <img src="{{ asset('imagenes/' . $producto->imagen) }}" class="card-img-top" alt="{{ $producto->nombre }}" />
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $producto->nombre }}</h5>
              <p class="card-text flex-grow-1">{{ Str::limit($producto->descripcion, 80) }}</p>
              <a href="#" class="btn btn-primary mt-auto">${{ number_format($producto->precio, 0, ',', '.') }}</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  {{-- FOOTER --}}
  <footer class="text-center py-4 bg-light">
    <img src="{{ asset('imagenes/Fondo_new__Blazing.-Mesa-de-trabajo-1-01.png') }}" alt="Logo" height="50" class="mb-3" />
    <p>Somos un E-commerce de venta de ropa personalizada.</p>
    <p>Manejamos gran variedad de diseños para cada uno de nuestros productos.</p>
    <small class="text-muted">&copy; 2025 Blazing Store. Todos los derechos reservados.</small>
  </footer>

  {{-- BOTÓN VOLVER ARRIBA --}}
  <button id="scrollTopBtn" title="Volver arriba">↑</button>

  {{-- SCRIPTS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Mostrar botón volver arriba
    const scrollBtn = document.getElementById("scrollTopBtn");
    window.onscroll = () => {
      scrollBtn.style.display = window.scrollY > 300 ? "block" : "none";
    };
    scrollBtn.onclick = () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // Navbar animada al hacer scroll
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        navbar.classList.add('navbar-shrink');
      } else {
        navbar.classList.remove('navbar-shrink');
      }
    });

    // Animación de entrada para productos
    document.addEventListener("DOMContentLoaded", () => {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add("fade-in");
          }
        });
      }, { threshold: 0.1 });

      document.querySelectorAll('.card').forEach(card => {
        observer.observe(card);
      });
    });

    if (window.location.hash === "#carousel") {
      window.addEventListener("load", () => {
        const carouselElement = document.getElementById("heroCarousel");
        if (carouselElement) {
          carouselElement.scrollIntoView({ behavior: 'smooth' });
        }
      });
    }
  </script>
</body>
</html>
