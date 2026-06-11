<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\HandleAppearance;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->encryptCookies(except: ['appearence', 'sidebar_state']);

        $middleware->web(append:[
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->trustProxies(
            '*',
            Request :: HEADER_X_FORWARDED_FOR |
            Request :: HEADER_X_FORWARDED_HOST |
            Request :: HEADER_X_FORWARDED_PORT |
            Request :: HEADER_X_FORWARDED_PROTO |

        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

    // class TrustProxies extends Middleware
    // {
    //     protected $proxies = '*';
    //     protected $headers =
    //     Request::HEADER_X_FORWARDED_FOR |
    //     Request::HEADER_X_FORWARDED_HOST |
    //     Request::HEADER_X_FORWARDED_PORT |
    //     Request::HEADER_X_FORWARDED_PROTO;
    // }
