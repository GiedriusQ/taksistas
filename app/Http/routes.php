<?php

Route::group(['prefix' => 'api'], function () {
    Route::post('login', 'API\LoginController@check');
    Route::group(['middleware' => 'auth.basic.once'], function () {
        Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
            Route::get('users/admins', 'API\Admin\UsersController@admins');
            Route::get('users/admins/detailed', 'API\Admin\UsersController@detailedAdmins');
            Route::get('users/drivers', 'API\Admin\UsersController@drivers');
            Route::get('users/drivers/detailed', 'API\Admin\UsersController@detailedDrivers');
            Route::get('users/dispatchers', 'API\Admin\UsersController@dispatchers');
            Route::get('users/dispatchers/detailed', 'API\Admin\UsersController@detailedDispatchers');
            Route::post('users/admins', 'API\Admin\UsersController@storeAdmins');
            Route::post('users/dispatchers', 'API\Admin\UsersController@storeDispatchers');
            Route::resource('users', 'API\Admin\UsersController', ['except' => ['edit', 'create', 'store']]);
            Route::resource('orders', 'API\Admin\OrdersController', ['only' => ['index', 'show']]);
            Route::resource('orders.statuses', 'API\Admin\OrderStatusesController', ['only' => ['index']]);
            Route::resource('dispatchers.drivers', 'API\Admin\DispatcherDriversController',
                ['except' => ['edit', 'create']]);
            Route::resource('drivers.orders', 'API\Admin\DriverOrdersController', ['only' => ['index', 'show']]);
            Route::get('drivers/{driver}/orders/{order}/statuses',
                'API\Admin\OrderStatusesController@driverOrderStatuses');
        });
        Route::group(['middleware' => 'dispatcher', 'prefix' => 'dispatcher'], function () {
            Route::resource('orders', 'API\Dispatcher\OrdersController', ['except' => ['create', 'edit']]);
            Route::resource('drivers', 'API\Dispatcher\DriversController', ['except' => ['create', 'edit']]);
            Route::resource('drivers.orders', 'API\Dispatcher\DriverOrdersController', ['only' => ['index', 'show']]);
        });
        Route::group(['middleware' => 'driver', 'prefix' => 'driver'], function () {
            Route::resource('orders', 'API\Driver\OrdersController', ['only' => ['index', 'show', 'update']]);
            Route::resource('locations', 'API\Driver\LocationsController', ['only' => ['index', 'store']]);
        });
    });
});

Route::group(['prefix' => 'frontend'], function () {
    Route::get('/', function () {
        if (!session('user')) {
            return redirect()->action('Front\LoginController@getLogin');
        }

        return redirect()->action('Front\HomeController@getHome');
    });
    Route::controller('login', 'Front\LoginController');
    Route::group(['middleware' => 'frontend.auth'], function () {
        Route::controller('home', 'Front\HomeController');
        Route::group(['middleware' => 'frontend.admin', 'prefix' => 'admin'], function () {
            Route::controller('order', 'Front\Admin\OrderController');
            Route::controller('user', 'Front\Admin\UserController');
        });
        Route::group(['middleware' => 'frontend.dispatcher', 'prefix' => 'dispatcher'], function () {
            Route::controller('driver', 'Front\Dispatcher\DriverController');
            Route::controller('order', 'Front\Dispatcher\OrderController');
        });
        Route::group(['middleware' => 'frontend.driver', 'prefix' => 'driver'], function () {
            Route::controller('order', 'Front\Driver\OrderController');
            Route::controller('location', 'Front\Driver\LocationController');
        });
    });
});
Route::get('/', function () {
    return redirect('/frontend');
});