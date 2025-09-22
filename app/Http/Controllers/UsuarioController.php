<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol')->get();
        return view('usuarios.listausuarios', compact('usuarios'));
    }

    public function create()
    {
        $roles = Rol::all();
        return view('usuarios.crearusuario', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo',
            'password_usu' => 'required|min:6',
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

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $roles = Rol::all();
        return view('usuarios.editarusuario', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuarios,correo,' . $usuario->id_usuario . ',id_usuario',
            'id_rol' => 'required|exists:rol,id_rol',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;
        $usuario->id_rol = $request->id_rol;

        if ($request->filled('password_usu')) {
            $usuario->password_usu = Hash::make($request->password_usu);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado.');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado.');
    }
}
