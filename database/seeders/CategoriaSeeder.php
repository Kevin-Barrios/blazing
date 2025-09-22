<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            ['nombre' => 'Camisas'],
            ['nombre' => 'Chaquetas'],
            ['nombre' => 'Buzos'],
            ['nombre' => 'Camisetas'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
