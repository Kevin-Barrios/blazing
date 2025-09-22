<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MetodoPagoSeeder extends Seeder
{
    public function run()
    {
        $metodos = [
            [
                'nombre' => 'Tarjeta de Crédito',
                'descripcion' => 'Pago mediante tarjeta de crédito Visa, MasterCard o American Express',
            ],
            [
                'nombre' => 'Tarjeta de Débito',
                'descripcion' => 'Pago mediante tarjeta de débito bancaria',
            ],
            [
                'nombre' => 'PayPal',
                'descripcion' => 'Pago seguro mediante PayPal',
            ],
            [
                'nombre' => 'Transferencia Bancaria',
                'descripcion' => 'Pago mediante transferencia desde su banco',
            ],
            [
                'nombre' => 'Contra Entrega',
                'descripcion' => 'Pago en efectivo al momento de recibir el pedido',
            ],
        ];

        foreach ($metodos as $metodo) {
            DB::table('metodo_pagos')->insert([
                'nombre' => $metodo['nombre'],
                'descripcion' => $metodo['descripcion'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
