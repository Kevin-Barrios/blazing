<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DireccionEnvioSeeder extends Seeder
{
    public function run()
    {
        DB::table('direccion_envio')->insert([
            [
                'id_usuario' => 2, // Ana Cliente
                'direccion' => 'Calle Falsa 123',
                'ciudad' => 'Ciudad de México',
                'departamento' => 'CDMX',
                'pais' => 'México',
                'telefono' => '5551234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
