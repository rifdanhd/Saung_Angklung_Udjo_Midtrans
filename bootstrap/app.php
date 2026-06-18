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
   ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'setlocale' => \App\Http\Middleware\SetLocale::class,
    ]);

    $middleware->web(append: [
        \App\Http\Middleware\SetLocale::class,
    ]);

    // Tambahkan ini! 👇
    $middleware->validateCsrfTokens(except: [
        'payment/notification',
        'midtrans/notification',
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
