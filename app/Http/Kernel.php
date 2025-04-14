<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'auth.egresado' => \App\Http\Middleware\AuthenticateEgresado::class,
        'auth.jefe_egresado' => \App\Http\Middleware\AuthenticateJefeEgresado::class,
        'auth.any' => \App\Http\Middleware\CheckAnyAuth::class,
    ];

    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // ...
        ],
        'jefe' => [
            'web',
            'auth:jefe_egresado',
            'auth.jefe',
        ],
    ];

    protected $middlewareAliases = [
        // ... otros middlewares ...
        'auth.any' => \App\Http\Middleware\CheckAnyAuth::class,
        'auth.jefe' => \App\Http\Middleware\JefeEgresadoMiddleware::class,
        'check.auth' => \App\Http\Middleware\CheckAnyAuth::class,
    ];
} 