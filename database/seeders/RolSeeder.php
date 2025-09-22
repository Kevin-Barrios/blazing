<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run()
    {
        DB::table('rol')->insert([
            ['nombre' => 'Administrador', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Cliente', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
