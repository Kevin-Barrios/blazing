<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\MetodoPago;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CompraController extends Controller
{
    public function create()
    {
        // Traer productos (si los necesitas en el formulario)
        $productos = \App\Models\Producto::all();

        return view('compras.registrarcompra', compact('productos'));
    }

    /**
     * Aquí en vez de "guardar" usamos "store" 
     * porque es lo que espera Route::resource('compras', ...)
     */
    public function store(Request $request)
    {
        // Lógica de compra rápida (si viene directo del formulario registrarcompra)
        session()->forget('cart');

        return redirect()->route('admin.dashboard')
                         ->with('success', '¡Compra registrada exitosamente!');
    }

    // Guardar carrito en sesión y redirigir a seleccionar método
    public function guardarCarritoEnSesion(Request $request)
    {
        $cart = json_decode($request->cart, true);

        if (empty($cart)) {
            return redirect()->route('carrito')->with('error', 'El carrito está vacío.');
        }

        // Guardar carrito en sesión
        session(['cart' => $cart]);

        return redirect()->route('seleccionar-metodo');
    }

    // Mostrar la página de selección de método de pago
    public function seleccionarMetodo()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('carrito')->with('error', 'El carrito está vacío.');
        }

        $metodos = MetodoPago::all();
        return view('compras.seleccionar_metodo', compact('cart', 'metodos'));
    }

    // Finalizar compra con carrito + método de pago
    public function finalizarCompra(Request $request)
    {
        $request->validate([
            'metodo_pago_id' => 'required|integer|exists:metodo_pagos,id',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('carrito')->with('error', 'El carrito está vacío.');
        }

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['precio'] * $item['quantity'];
        }
        $iva = $total * 0.19;
        $totalConIva = $total + $iva;

        try {
            $compra = Compra::create([
                'id_usuario'      => $user->id_usuario,
                'total'           => $totalConIva,
                'iva_total'       => $iva,
                'fecha_compra'    => Carbon::now(),
                'metodo_pago_id'  => $request->metodo_pago_id,
            ]);

            foreach ($cart as $item) {
                DetalleCompra::create([
                    'id_compra'       => $compra->id,
                    'id_producto'     => $item['id_producto'],
                    'cantidad'        => $item['quantity'],
                    'precio_unitario' => $item['precio'],
                    'subtotal'        => $item['precio'] * $item['quantity'],
                ]);
            }

            session()->forget('cart');

            return redirect()->route('catalogo')
                             ->with('success', 'Compra realizada con éxito. ¡Gracias por tu pedido!');

        } catch (\Exception $e) {
            \Log::error('Error al finalizar compra: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al intentar finalizar la compra.');
        }
    }
}
