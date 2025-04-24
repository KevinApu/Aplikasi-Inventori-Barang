<?php

use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\ClearTempItems;
use App\Http\Middleware\KhususAdmin;
use App\Http\Middleware\NotSuperAdmin;
use App\Http\Middleware\SuperAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => CheckAdmin::class,
            'khusus_admin' => KhususAdmin::class,
            'super_admin' => SuperAdmin::class,
            'not_super_admin' => NotSuperAdmin::class,
            'clear.temp_items' => ClearTempItems::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
