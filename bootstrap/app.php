<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust all proxies (Railway, Vercel, etc.)
        $middleware->trustProxies(at: '*');

        // Alias middleware
        $middleware->alias([
            'auth'       => \App\Http\Middleware\Authenticate::class,
            'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            'admin'      => \App\Http\Middleware\AdminMiddleware::class,
            'rolecheck'  => \App\Http\Middleware\Rolecheck::class,
            'guest'      => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
