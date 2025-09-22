<?php

namespace App\Http\Controllers;

use App\Models\Compra;

class HistorialComprasController extends Controller
{
    public function index()
    {
        // Traemos todas las compras con el usuario que la hizo
        $compras = Compra::with('usuario')
                         ->orderBy('fecha_compra', 'desc')
                         ->get();

        return view('admin.historialcompra', compact('compras'));
    }
}
