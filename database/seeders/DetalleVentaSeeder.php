<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetalleVentaSeeder extends Seeder
{
    public function run()
    {
        DB::table('detalle_venta')->insert([
        'id_venta' => 1,
        'id_producto' => 1,
        'cantidad' => 1,
        'precio_unitario' => 1500.00,
        'subtotal' => 1500.00, // cantidad * precio_unitario
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    }
}
