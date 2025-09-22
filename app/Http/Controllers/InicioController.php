<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Slider;

class InicioController extends Controller
{
    public function index()
    {
        $productosBD = Producto::where('activo', true)->get();

        $heroSlides = [
            (object)[
                'imagen' => 'banner1.jpg',
                'titulo' => 'Ropa Personalizada de Calidad',
                'descripcion' => 'Descubre nuestros diseños exclusivos y siente la diferencia.',
                'url' => url('/catalogo')
            ],
            (object)[
                'imagen' => 'banner2.jpg',
                'titulo' => 'Nuevas Colecciones 2025',
                'descripcion' => 'Renueva tu estilo con nuestra última moda.',
                'url' => url('/catalogo')
            ],
            (object)[
                'imagen' => 'banner3.jpg',
                'titulo' => 'Ofertas Especiales',
                'descripcion' => 'Aprovecha descuentos únicos por tiempo limitado.',
                'url' => url('/ofertas')
            ],
        ];

        return view('cliente.inicio', compact('productosBD', 'heroSlides'));
    }

    public function inicio()
    {
        $productosBD = Producto::all();
        $heroSlides = Slider::all();

        return view('inicio', compact('productosBD', 'heroSlides'));
    }
}
