<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::where('activo', 1);

        // Filtro por categoría (nombre, no ID)
        if ($request->has('categoria')) {
            $query->whereHas('categoria', function ($q) use ($request) {
                $q->where('nombre', $request->categoria);
            });
        }

        // Filtro por talla
        if ($request->filled('talla')) {
            $query->where('talla', $request->talla);
        }

        $products = $query->get();

        // Obtener todas las tallas únicas disponibles (según categoría si se quiere)
        $tallas = Producto::where('activo', 1)
            ->when($request->has('categoria'), function ($q) use ($request) {
                $q->whereHas('categoria', function ($q2) use ($request) {
                    $q2->where('nombre', $request->categoria);
                });
            })
            ->pluck('talla')
            ->unique()
            ->filter()
            ->values();

        return view('cliente.catalogo', compact('products', 'tallas'));
    }
}
