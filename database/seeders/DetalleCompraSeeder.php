<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetalleCompraSeeder extends Seeder
{
    public function run()
    {
            DB::table('detalle_compra')->insert([
                'id_compra' => 1,
                'id_producto' => 1,
                'cantidad' => 2,
                'precio_unitario' => 500.00,
                'subtotal' => 2 * 500.00,  // 1000.00
                'created_at' => now(),
                'updated_at' => now(),
    ]);

    }
}
