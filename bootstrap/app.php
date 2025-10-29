<?php

use App\Http\Middleware\ShowMessage;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // aggiunge middleware al gruppo web
        $middleware->web([
            App\Http\Middleware\ShowMessage::class,
            App\Http\Middleware\WorkingHours::class,
        ]);

        // aggiunge middleware al gruppo api
//        $middleware->api([
//            'MiddlewareDaAppendereAlGruppoWeb'
//        ]);


        // definizione alias per middleware di rotta
        $middleware->alias([
            'set-attribute' => \App\Http\Middleware\SetAttribute::class,
        ]);

        // aggiunge middleware a un gruppo generico
//        $middleware->appendToGroup('my-group', [
//            Middleware1::class,
//            Middleware2::class,
//            Middleware3::class,
//            Middleware4::class,
//        ]);


        // impostazione priorità dei middleware
        $middleware->priority([
            \Illuminate\Session\Middleware\StartSession::class,
            App\Http\Middleware\WorkingHours::class,
            ShowMessage::class,
        ]);
    })
//    ->withEvents([  // registrazione percorsi alternativi per i listeners
//        __DIR__ . '/../app/MyListeners'
//    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
