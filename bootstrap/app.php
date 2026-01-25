

<?php

use App\Http\Middleware\EnsureUserIsHost;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role'      => EnsureUserIsHost::class,  
            'admin'     => EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function () {
        
    })
    ->create();