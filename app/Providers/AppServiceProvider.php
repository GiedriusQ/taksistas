<?php

namespace App\Providers;

use App\Order;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Order::created(function ($order) {
            $status             = $order->statusHistory()->create(['status' => 0, 'user_id' => $order->dispatcher_id]);
            $status->created_at = $order->created_at;
            $status->save();

            return true;
        });
        Order::updating(function ($order) {
            if ($order->isDirty('status')) {
                $order->statusHistory()->create([
                    'status'  => $order->status,
                    'user_id' => $order->dispatcher_id
                ]);
            }

            return true;
        });
        view()->composer('*', function ($view) {
            $view->with('user', session('user'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
