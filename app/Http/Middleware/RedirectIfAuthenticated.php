<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated as Middleware;

class RedirectIfAuthenticated extends Middleware
{
    /**
     * The URIs that should be excluded from authentication checks.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
