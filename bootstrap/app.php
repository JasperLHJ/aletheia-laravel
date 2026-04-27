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
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'noindex' => \App\Http\Middleware\NoIndexPrivate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Ensures a line appears in App Platform / Apache / php-fpm logs even when
        // file logging or LOG_CHANNEL is misconfigured (stderr alone can be hard to see).
        $exceptions->reportable(function (\Throwable $e) {
            if (app()->environment('testing')) {
                return;
            }

            error_log(sprintf(
                '[laravel] %s: %s in %s:%d',
                $e::class,
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));
        });
    })->create();
