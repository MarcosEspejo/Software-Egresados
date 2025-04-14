<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): string
    {
        if (!$request->expectsJson()) {
            // Obtener la ruta actual
            $currentPath = $request->path();
            
            // Si la URL comienza con jefe-egresados
            if (str_starts_with($currentPath, 'jefe-egresados')) {
                return route('jefe_egresados.login');
            }
            
            // Si la URL comienza con egresados
            if (str_starts_with($currentPath, 'egresados')) {
                return route('egresados.login');
            }
            
            // Por defecto, redirigir al login de egresados
            return route('egresados.login');
        }
    }
} 