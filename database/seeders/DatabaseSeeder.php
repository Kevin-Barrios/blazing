<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run()
{
    $this->call([
        RolSeeder::class,
        UsuarioSeeder::class,
        CategoriaSeeder::class,
        ProductoSeeder::class,
        InventarioSeeder::class,
        IvaSeeder::class,
        PedidoSeeder::class,
        PedidoProductoSeeder::class,
        CarritoSeeder::class,
        ComentarioSeeder::class,
        VentaSeeder::class,
        DetalleVentaSeeder::class,
        CompraSeeder::class,
        DetalleCompraSeeder::class,
        MetodoPagoSeeder::class,
        
    ]);
}


}
