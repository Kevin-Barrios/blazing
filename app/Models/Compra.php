<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';
    protected $primaryKey = 'id_compra';
    // Si tu tabla compras tampoco tiene timestamps, descomenta esta línea:
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'total',
        'iva_total',
        'fecha_compra',
        // Removemos id_pago ya que no existe la columna
    ];

    protected $casts = [
        'fecha_compra' => 'datetime',
        'total' => 'decimal:2',
        'iva_total' => 'decimal:2',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'id_compra');
    }

    // Removemos la relación con pago ya que no hay columna id_pago
}
