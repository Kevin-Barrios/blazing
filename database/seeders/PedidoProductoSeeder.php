<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidoProductoSeeder extends Seeder
{
    public function run()
    {
        DB::table('pedido_producto')->insert([
            [
                'id_pedido' => 1,
                'id_producto' => 1,
                'cantidad' => 2,
                'precio_unitario' => 25.99,
                'subtotal' => 51.98,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
