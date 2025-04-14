<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAnyAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('web')->check() || Auth::guard('jefe_egresado')->check()) {
            return $next($request);
        }

        if ($request->is('jefe-egresados*')) {
            return redirect()->route('jefe_egresados.login');
        }

        return redirect()->route('egresados.login');
    }
} 