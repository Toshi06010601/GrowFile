<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middleware\AccessLogging;
use App\Http\Middleware\AddContext;
use App\Http\Middleware\SetLocale;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prependToPriorityList(
            before: SubstituteBindings::class,
            prepend: SetLocale::class,
        );
        $middleware->web(append: [
            AddContext::class,
            AccessLogging::class,
            SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->context(fn () => [
        'user_id' => auth()->id(),
        'env' => app()->environment(),
        'url' => request()->fullUrl(),
    ]);
    })->create();

    