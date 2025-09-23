@extends('layouts.app')

@section('title', 'Home - Blazing')

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Eleva tu estilo</h1>
            <p>Descubre lo último en moda y calzado exclusivo.</p>
            <a href="#" class="btn-hero">Comprar ahora</a>
        </div>
        <div class="hero-image">
            <img src="{{ asset('imagenes/banner2.jpg') }}" alt="Hero Image">
        </div>
    </section>

    <!-- Productos destacados -->
    <section class="featured">
        <h2>Destacados</h2>
        <div class="products-grid">
            <div class="product-card">
                <img src="{{ asset('imagenes/camisa totoro.jpeg') }}" alt="Producto 1">
                <h3>Camisa Totoro</h3>
                <p>$120.00</p>
            </div>
            <div class="product-card">
                <img src="{{ asset('imagenes/spider.jpg') }}" alt="Producto 2">
                <h3>Camisa Spyder Woman</h3>
                <p>$85.00</p>
            </div>
            <div class="product-card">
                <img src="{{ asset('imagenes/vegetta.jpeg') }}" alt="Producto 3">
                <h3>Camisa Vegetta</h3>
                <p>$60.00</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="cta">
        <h2>Únete a nuestra comunidad</h2>
        <p>Accede a lanzamientos exclusivos y beneficios únicos.</p>
        <a href="{{ route('login') }}" class="btn-login">Iniciar Sesión</a>
    </section>
@endsection
