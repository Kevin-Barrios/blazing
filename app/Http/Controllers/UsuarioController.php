<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Mostrar lista de usuarios
     */
    public function index()
    {
        $usuarios = Usuario::with('rol')->get();
        return view('usuarios.listausuarios', compact('usuarios'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $roles = Rol::all();
        return view('usuarios.crearusuario', compact('roles'));
    }

    /**
     * Guardar un nuevo usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'password_usu' => 'required|min:6|confirmed',
            'id_rol' => 'required|exists:rol,id_rol',
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'password_usu' => Hash::make($request->password_usu),
            'id_rol' => $request->id_rol,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id_usuario)
    {
        $usuario = Usuario::findOrFail($id_usuario);
        $roles = Rol::all();
        return view('usuarios.editarusuario', compact('usuario', 'roles'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, $id_usuario)
    {
        $usuario = Usuario::findOrFail($id_usuario);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo,' . $usuario->id_usuario . ',id_usuario',
            'id_rol' => 'required|exists:rol,id_rol',
            'password_usu' => 'nullable|min:6|confirmed',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->id_rol = $request->id_rol;

        if ($request->filled('password_usu')) {
            $usuario->password_usu = Hash::make($request->password_usu);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario
     */
    public function destroy($id_usuario)
    {
        $usuario = Usuario::findOrFail($id_usuario);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}

