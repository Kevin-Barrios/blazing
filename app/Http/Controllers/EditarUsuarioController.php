<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario; 

class EditarUsuarioController extends Controller
{
    public function editar()
    {
        $usuario = Auth::user(); 
        return view('cliente.perfil', compact('usuario'));
    }

    public function actualizar(Request $request)
    {
        $usuario = Auth::user();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:usuarios,correo,' . $usuario->id,
            'password_usu' => 'nullable|string|min:6|confirmed',
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->correo = $request->correo;

        if ($request->password_usu) {
            $usuario->password_usu = Hash::make($request->password_usu);
        }

        $usuario->save();

        return redirect()->route('usuario.perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
