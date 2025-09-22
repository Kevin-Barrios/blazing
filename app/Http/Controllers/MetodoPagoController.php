<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;
use Illuminate\Http\Request;

class MetodoPagoController extends Controller
{
    public function index()
    {
        $metodos = MetodoPago::all();
        $cart = session('cart', []);
        return view('compras.seleccionar_metodo', compact('metodos', 'cart'));

    }

    public function create()
    {
        return view('metodos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        MetodoPago::create($request->all());
        return redirect()->route('metodos.index')->with('success', 'Método de pago creado.');
    }

    public function edit(MetodoPago $metodoPago)
    {
        return view('metodos.edit', compact('metodoPago'));
    }

    public function update(Request $request, MetodoPago $metodoPago)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $metodoPago->update($request->all());
        return redirect()->route('metodos.index')->with('success', 'Método de pago actualizado.');
    }

    public function destroy(MetodoPago $metodoPago)
    {
        $metodoPago->delete();
        return redirect()->route('metodos.index')->with('success', 'Método de pago eliminado.');
    }
}
