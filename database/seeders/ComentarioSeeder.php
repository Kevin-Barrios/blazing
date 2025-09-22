<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComentarioSeeder extends Seeder
{
    public function run()
    {
        DB::table('comentarios')->insert([
            [
                'id_usuario' => 2,
                'id_producto' => 1,
                'comentario' => 'Excelente calidad y muy cómodo.',
                'calificacion' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
