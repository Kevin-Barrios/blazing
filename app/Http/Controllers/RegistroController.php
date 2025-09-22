<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario; // Modelo para la tabla 'usuarios'
use App\Models\Rol;        // Modelo para la tabla 'rol'
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegistroController extends Controller
{
    // Muestra el formulario de registro con los roles disponibles
    public function crear()
    {
        // Si quieres excluir el rol de administrador, por ejemplo con id_rol = 1
        // $roles = Rol::where('id_rol', '!=', 1)->get();

        // Si quieres mostrar todos los roles:
        $roles = Rol::all();

        return view('cliente.registro', compact('roles'));
    }

    // Guarda al nuevo usuario
    public function guardar(Request $request)
    {
        // Validación de los datos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'contrasena' => 'required|string|min:6|confirmed',
            'id_rol' => 'required|exists:rol,id_rol',
        ], [
            'contrasena.confirmed' => 'La confirmación de la contraseña no coincide.',
            'id_rol.required' => 'Debes seleccionar un rol.',
            'id_rol.exists' => 'El rol seleccionado no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Crear el usuario con los datos validados
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->password_usu = Hash::make($request->input('contrasena'));
        $usuario->id_rol = $request->id_rol;

        // Guardar el usuario en la base de datos
        $usuario->save();

        // Redirigir al login con un mensaje de éxito
        return redirect()->route('login')->with('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }
}




