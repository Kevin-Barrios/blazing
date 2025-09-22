<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedidoSeeder extends Seeder
{
    public function run()
    {
        DB::table('pedidos')->insert([
            [
                'id_usuario' => 2,
                'descripcion_pedido' => 'Pedido para Ana Cliente',
                'total_pedido' => 51.98,
                'metodo_pago' => 'Tarjeta de crédito',
                'direccion_entrega' => 'Calle Falsa 123, Ciudad de México',
                'telefono_contacto' => '5551234567',
                'estados' => 'pendiente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
