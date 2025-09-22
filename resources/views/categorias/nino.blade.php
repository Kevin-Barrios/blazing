@extends('layouts.app')

@section('title', 'Ropa para Niño - Blazing')

@section('content')
<div class="catalogo-container py-5">
    <h2 class="text-center mb-5 section-title">Colección Hombre</h2>
    
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card catalogo-card h-100 shadow-sm">
                <img src="{{ asset('imagenes/jujutsu_kaizen.jpeg') }}" class="card-img-top" alt="Camisa casual">
                <div class="card-body text-center">
                    <h5 class="card-title">Camisa ANIME Jujutsu Kaizen</h5>
                    <p class="card-text precio">$89.900</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card catalogo-card h-100 shadow-sm">
                <img src="{{ asset('imagenes/kimetsu.jpg') }}" class="card-img-top" alt="Chaqueta deportiva">
                <div class="card-body text-center">
                    <h5 class="card-title">Camisa ANIME Kimetsu No Yaiba</h5>
                    <p class="card-text precio">$159.900</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card catalogo-card h-100 shadow-sm">
                <img src="{{ asset('imagenes/vegetta.jpeg') }}" class="card-img-top" alt="Chaqueta deportiva">
                <div class="card-body text-center">
                    <h5 class="card-title">Camisa Vegetta</h5>
                    <p class="card-text precio">$129.900</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card catalogo-card h-100 shadow-sm">
                <img src="{{ asset('imagenes/totoro.jpeg') }}" class="card-img-top" alt="Chaqueta deportiva">
                <div class="card-body text-center">
                    <h5 class="card-title">Camisa Totoro</h5>
                    <p class="card-text precio">$199.900</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
