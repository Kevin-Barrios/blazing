<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VentaSeeder extends Seeder
{
    public function run()
    {
            DB::table('ventas')->insert([
        'id_usuario' => 2,
        'total' => 1500.00,
        'fecha_venta' => now(),
        'iva_total' => 240.00, // opcional
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    }
}
