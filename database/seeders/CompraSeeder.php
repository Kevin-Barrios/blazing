<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompraSeeder extends Seeder
{
    public function run()
    {
        DB::table('compras')->insert([
        'id_usuario' => 1,
        'total' => 1000.00,
        'fecha_compra' => now(),
        'iva_total' => 160.00, // opcional
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    }
}
