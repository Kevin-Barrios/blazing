<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    
    // Desactivar timestamps automáticos
    public $timestamps = false;

    protected $fillable = [
        'metodo_pago', // Mantenemos como string del nombre del método
        'referencia_pago',
        'monto',
        'fecha_pago',
    ];

    protected $casts = [
        'fecha_pago' => 'datetime',
        'monto' => 'decimal:2',
    ];
}