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
            'superadmin' => \App\Http\Middleware\superadmin::class,
            'admin' => \App\Http\Middleware\admin::class,
            'admin.or.superadmin' => \App\Http\Middleware\AdminOrSuperadmin::class,
            'force.https' => \App\Http\Middleware\ForceHttps::class,
        ]);
        
        // Apply TrustProxies and ForceHttps middleware globally in production
        if (env('APP_ENV') === 'production') {
            $middleware->web(append: [
                \App\Http\Middleware\TrustProxies::class,
                \App\Http\Middleware\ForceHttps::class,
            ]);
        }
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
