<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario; // Modelo para la tabla 'usuarios'
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistroController extends Controller
{
    // Muestra el formulario de registro
    public function crear()
    {
        return view('cliente.registro');
    }

    // Guarda al nuevo usuario
    public function guardar(Request $request)
    {
        // Validación de los datos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|string|min:6|confirmed',
        ], [
            'contrasena.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Crear el usuario con los datos validados y rol automático
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->password_usu = Hash::make($request->input('contrasena'));
        $usuario->id_rol = 2; // Asignar automáticamente el rol Cliente

        // Guardar el usuario en la base de datos
        $usuario->save();

        // Redirigir al login con un mensaje de éxito
        return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }
}




