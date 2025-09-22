<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Sesion extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'correo',
        'password_usu',
        'id_rol',
    ];

    protected $hidden = [
        'password_usu',
    ];

    /**
     * Método necesario para que Auth::attempt sepa qué campo es la contraseña.
     */
    public function getAuthPassword()
    {
        return $this->password_usu;
    }
}




