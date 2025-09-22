<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\KasirMiddleware;
use App\Http\Middleware\AuthenticatedOnly;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'kasir' => \App\Http\Middleware\KasirMiddleware::class,
            'user' => \App\Http\Middleware\UserMiddleware::class,
            'role' => \App\Http\Middleware\CheckRole::class,
            'auth.custom' => \App\Http\Middleware\AuthenticatedOnly::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
