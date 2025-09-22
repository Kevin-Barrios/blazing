<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarioSeeder extends Seeder
{
    public function run()
    {
       DB::table('inventario')->insert([
    ['id_producto' => 1, 'talla' => 'M', 'color' => 'Azul', 'stock' => 10],
    ['id_producto' => 2, 'talla' => 'L', 'color' => 'Negro', 'stock' => 50],
]);

    }
}
