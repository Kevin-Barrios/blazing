<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function MostrarFormulario()
    {
        return view('pago');
    }

    public function ProcesarPago(Request $request)
    {
        $request->validate([
            'NumeroTarjeta' => 'required|string',
            'TitularTarjeta' => 'required|string',
            'Monto' => 'required|numeric',
            'MetodoPago' => 'required|string',
        ]);

        // Aquí podrías integrar la lógica real de pago con la API externa.
        // Por ahora simulamos que el pago siempre es exitoso.

        $exito = true; // Simulación

        if ($exito) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}
