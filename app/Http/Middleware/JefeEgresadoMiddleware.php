<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JefeEgresadoMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('jefe_egresado')->check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }
            return redirect()->route('jefe_egresados.login');
        }

        return $next($request);
    }
}
