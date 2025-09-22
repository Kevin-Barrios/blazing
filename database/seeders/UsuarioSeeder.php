<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        DB::table('usuarios')->insert([
            [
                'nombre' => 'Rodrigo Admin',
                'correo' => 'rodrigo@admin.com',
                'password_usu' => Hash::make('password123'),
                'id_rol' => 1, // Asignando rol Administrador directamente
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ana Cliente',
                'correo' => 'ana@cliente.com',
                'password_usu' => Hash::make('password123'),
                'id_rol' => 2, // Asignando rol Cliente directamente
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Santiago Diaz',
                'correo' => 'santydiaz@gmail.com',
                'password_usu' => Hash::make('password123'),
                'id_rol' => 2, // Asignando rol Cliente directamente
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
