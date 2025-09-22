<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Compra;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::count();

        $productos = Producto::where('activo', 1)->count();

        $productosConCantidad = Producto::select('nombre', 'cantidad')
            ->where('activo', 1)
            ->orderByDesc('cantidad')
            ->take(5)
            ->get();

        $totalCompras = Compra::count();
        $ingresosTotales = Compra::sum('total');

        $ultimasCompras = Compra::with('usuario')
            ->latest('fecha_compra')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'usuarios',
            'productos',
            'productosConCantidad',
            'totalCompras',
            'ingresosTotales',
            'ultimasCompras'
        ));
    }
}
