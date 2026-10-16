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
            'role' => \App\Http\Middleware\CheckRole::class,
            'prefs' => \App\Http\Middleware\HandleUserPreferences::class,
            'api.token' => \App\Http\Middleware\ApiTokenMiddleware::class,
            'honeypot' => \App\Http\Middleware\HoneypotTrap::class,
            'internal' => \App\Http\Middleware\RestrictClientAccess::class,
        ]);

        $middleware->append(\App\Http\Middleware\HoneypotTrap::class);

        // user_prefs is intentionally left inside the encrypted-cookie set. The prefs
        // middleware unserializes it, so its integrity has to depend on APP_KEY; that is
        // what ties the diagnostic file read to the deserialization step in the lab.
        // Adding an encryptCookies() exception here would hand the sink an unauthenticated
        // attacker-controlled string and quietly collapse those two steps into one.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Tangani semua HttpException (401, 403, 404, 419, 429, 500, 503)
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e, $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return null;
            }

            $status = $e->getStatusCode();
            if (view()->exists("errors.{$status}")) {
                return response()->view("errors.{$status}", [
                    'exception' => $e,
                    'code' => $status,
                ], $status, $e->getHeaders());
            }
        });

        // Tangani crash/unhandled exception (500) saat di environment produksi (APP_DEBUG=false)
        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->is('api/*') || $request->expectsJson()) {
                return null;
            }

            if (! config('app.debug')) {
                return response()->view('errors.500', [
                    'exception' => $e,
                    'code' => 500,
                ], 500);
            }
        });
    })->create();