<?php

namespace App\Providers;

use App\User;
use App\Order;
use Exception;
use Illuminate\Routing\Router;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $throwModelNotFound = function () {
            throw new ModelNotFoundException;
        };
        $router->model('admins', User::class, $throwModelNotFound);
        $router->model('dispatchers', User::class, $throwModelNotFound);
        $router->model('drivers', User::class, $throwModelNotFound);
        $router->bind('orders', function ($id) {
            try {
                return Order::with('statusHistory')->find($id);
            } catch (Exception $e) {
                $this->throwModelNotFound();
            }
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }

    protected function throwModelNotFound()
    {
        throw new ModelNotFoundException;
    }
}
