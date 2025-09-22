<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('cliente.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'correo' => $request->correo,
            'password' => $request->password
        ];

        // Intentar login con Auth
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $usuario = Auth::user();

            // Redirigir según el rol
            if ($usuario->rol->nombre === 'Administrador') {
                return redirect()->route('admin.dashboard');
            } elseif ($usuario->rol->nombre === 'Cliente') {
                return redirect()->route('inicio');
            }

            // Si el rol no es válido
            Auth::logout();
            return back()->withErrors(['rol' => 'Rol no válido.']);
        }

        // Si falla el login
        return back()->withErrors([
            'correo' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }
}
