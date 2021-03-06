<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        //\App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth.basic'      => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.basic.once' => \App\Http\Middleware\AuthenticateOnceWithBasicAuth::class,
        'admin'           => \App\Http\Middleware\AdminMiddleware::class,
        'driver'          => \App\Http\Middleware\DriverMiddleware::class,
        'dispatcher'      => \App\Http\Middleware\DispatcherMiddleware::class,
        'guest'           => \App\Http\Middleware\RedirectIfAuthenticated::class,

        'frontend.auth'       => \App\Http\Middleware\Frontend\ApiAuthentication::class,
        'frontend.admin'      => \App\Http\Middleware\Frontend\AdminMiddleware::class,
        'frontend.dispatcher' => \App\Http\Middleware\Frontend\DispatcherMiddleware::class,
        'frontend.driver'     => \App\Http\Middleware\Frontend\DriverMiddleware::class,
        'frontend.guest'      => \App\Http\Middleware\Frontend\RedirectIfAuthenticated::class,
    ];
}
