<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\MetodoPago;
use App\Models\Usuario;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CompraController extends Controller
{
    /**
     * Listar todas las compras
     */
    public function index()
    {
        $productos = Producto::all();
        $usuarios  = Usuario::all();
        return view('compras.registrarcompra', compact('productos', 'usuarios'));
    }


    /**
     * Mostrar formulario para registrar nueva compra (manual desde admin)
     */
    public function create()
    {
        $productos = Producto::all();
        $usuarios  = Usuario::all();

        return view('compras.registrarcompra', compact('productos', 'usuarios'));
    }

    /**
     * Guardar compra registrada manualmente
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'productos' => 'required|array|min:1',
            'productos.*.id_producto' => 'required|exists:productos,id_producto',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        $subtotal = 0;
        foreach ($request->productos as $producto) {
            $subtotal += $producto['cantidad'] * $producto['precio_unitario'];
        }

        $iva   = $subtotal * 0.19;
        $total = $subtotal + $iva;

        $compra = Compra::create([
            'id_usuario'   => $request->id_usuario,
            'total'        => $total,
            'iva_total'    => $iva,
            'fecha_compra' => now(),
        ]);

        foreach ($request->productos as $producto) {
            DetalleCompra::create([
                'id_compra'       => $compra->id_compra,
                'id_producto'     => $producto['id_producto'],
                'cantidad'        => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal'        => $producto['cantidad'] * $producto['precio_unitario'],
            ]);
        }

        return redirect()->route('compras.index')
                         ->with('success', 'Compra registrada correctamente.');
    }

    /**
     * Mostrar detalles de una compra
     */
    public function show($id)
    {
        $compra = Compra::with(['usuario', 'detalles'])->findOrFail($id);
        return view('compras.show', compact('compra'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $compra    = Compra::with('detalles')->findOrFail($id);
        $productos = Producto::all();
        $usuarios  = Usuario::all();

        return view('compras.edit', compact('compra', 'productos', 'usuarios'));
    }

    /**
     * Actualizar una compra
     */
    public function update(Request $request, $id)
    {
        $compra = Compra::findOrFail($id);

        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'productos' => 'required|array|min:1',
            'productos.*.id_producto' => 'required|exists:productos,id_producto',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        $subtotal = 0;
        foreach ($request->productos as $producto) {
            $subtotal += $producto['cantidad'] * $producto['precio_unitario'];
        }

        $iva   = $subtotal * 0.19;
        $total = $subtotal + $iva;

        $compra->update([
            'id_usuario'   => $request->id_usuario,
            'total'        => $total,
            'iva_total'    => $iva,
            'fecha_compra' => now(),
        ]);

        // eliminar detalles anteriores
        $compra->detalles()->delete();

        // volver a guardar detalles
        foreach ($request->productos as $producto) {
            DetalleCompra::create([
                'id_compra'       => $compra->id_compra,
                'id_producto'     => $producto['id_producto'],
                'cantidad'        => $producto['cantidad'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal'        => $producto['cantidad'] * $producto['precio_unitario'],
            ]);
        }

        return redirect()->route('compras.index')->with('success', 'Compra actualizada correctamente.');
    }

    /**
     * Eliminar compra
     */
    public function destroy($id)
    {
        $compra = Compra::findOrFail($id);
        $compra->detalles()->delete();
        $compra->delete();

        return redirect()->route('compras.index')->with('success', 'Compra eliminada correctamente.');
    }

    /* ------------------------
     * FUNCIONES DE CARRITO
     * ------------------------ */

    public function guardarCarritoEnSesion(Request $request)
    {
        $cart = json_decode($request->cart, true);

        if (empty($cart)) {
            return redirect()->route('carrito')->with('error', 'El carrito está vacío.');
        }

        session(['cart' => $cart]);

        return redirect()->route('seleccionar-metodo');
    }

    public function seleccionarMetodo()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('carrito')->with('error', 'El carrito está vacío.');
        }

        $metodos = MetodoPago::all();
        return view('compras.seleccionar_metodo', compact('cart', 'metodos'));
    }

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
            $metodoPago = MetodoPago::find($request->metodo_pago_id);

            if (!$metodoPago) {
                return redirect()->back()->with('error', 'Método de pago no válido.');
            }

            $compra = Compra::create([
                'id_usuario'   => $user->id_usuario,
                'total'        => $totalConIva,
                'iva_total'    => $iva,
                'fecha_compra' => Carbon::now(),
            ]);

            foreach ($cart as $item) {
                DetalleCompra::create([
                    'id_compra'       => $compra->id_compra,
                    'id_producto'     => $item['id_producto'],
                    'cantidad'        => $item['quantity'],
                    'precio_unitario' => $item['precio'],
                    'subtotal'        => $item['precio'] * $item['quantity'],
                ]);
            }

            session()->forget('cart');

            return redirect()->to('/catalogo')
                             ->with('success', 'Compra realizada con éxito. ¡Gracias por tu pedido!')
                             ->with('clear_cart', true);

        } catch (\Exception $e) {
            \Log::error('Error al finalizar compra: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al intentar finalizar la compra.');
        }
    }
}

