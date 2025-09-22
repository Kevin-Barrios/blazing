<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function mostrar()
    {
        $cartItems = [
            ['id' => 1, 'name' => 'Producto 1', 'description' => 'Descripción breve del producto 1.', 'price' => 100.00, 'quantity' => 1, 'image' => 'imagenes/imagen1.jpg'],
            ['id' => 2, 'name' => 'Producto 2', 'description' => 'Descripción breve del producto 2.', 'price' => 150.00, 'quantity' => 1, 'image' => 'imagenes/imagen2.jpg'],
            ['id' => 3, 'name' => 'Producto 3', 'description' => 'Descripción breve del producto 3.', 'price' => 200.00, 'quantity' => 1, 'image' => 'imagenes/imagen3.jpg'],
        ];

        return view('cliente.carrito', compact('cartItems')); 
    }
}
