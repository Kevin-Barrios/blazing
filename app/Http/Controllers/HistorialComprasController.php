<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Venta;

class HistorialComprasController extends Controller
{
    public function index()
    {
        // Traemos todas las compras con el usuario que la hizo
        $compras = Compra::with('usuario')
                        ->orderBy('fecha_compra', 'desc')
                        ->get();

        // Traemos todas las ventas con el usuario y los detalles de los productos
        $ventas = Venta::with(['usuario', 'detalles.producto'])->get();

        // Pasamos ambas variables a la vista
        return view('admin.historialcompra', compact('compras', 'ventas'));
    }

}
