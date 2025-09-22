<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && strtolower(trim(Auth::user()->type)) === 'admin') {
            return $next($request);
        }
        
        
        return redirect()->route('inicio')->withErrors('No tienes permisos para acceder a esta sección.');
    }
}
