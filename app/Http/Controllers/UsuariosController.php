<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsuariosController extends Controller
{
    /**
     * Mostrar lista de usuarios
     */
    public function index()
    {
        $usuarios = User::all();
        return view('admin.listausuarios', compact('usuarios'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('admin.crearusuario');
    }

    /**
     * Guardar un nuevo usuario
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->back()->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.editarusuario', compact('usuario'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
        ]);

        $usuario->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $usuario->password,
        ]);

        return redirect()->back()->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Eliminar usuario
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
    }
}
