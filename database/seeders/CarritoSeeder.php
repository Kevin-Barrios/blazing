<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarritoSeeder extends Seeder
{
    public function run()
    {
        DB::table('carrito')->insert([
            [
                'id_usuario' => 2,
                'id_producto' => 1,
                'cantidad' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
