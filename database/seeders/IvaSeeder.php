<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IvaSeeder extends Seeder
{
    public function run()
    {
        DB::table('iva')->insert([
        ['porcentaje' => 16.00, 'created_at' => now(), 'updated_at' => now()],
        ['porcentaje' => 8.00, 'created_at' => now(), 'updated_at' => now()],
    ]);

    }
}
