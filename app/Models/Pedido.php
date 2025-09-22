<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Pedido extends Model
{
    protected $table = 'pedidos';

    protected $fillable = [
        'id_usuario',
        'descripcion_pedido',
        'total_pedido',
        'metodo_pago',
        'direccion_entrega',
        'telefono_contacto',
        'estados'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}

