<?php
/*
+--------+----------+-------------------------------------------------------+---------------------------------------+----------------------------------------------------------------------------+----------------------------+
| Domain | Method   | URI                                                   | Name                                  | Action                                                                     | Middleware                 |
+--------+----------+-------------------------------------------------------+---------------------------------------+----------------------------------------------------------------------------+----------------------------+
|        | GET|HEAD | api/admin/admins                                      | api.admin.admins.index                | App\Http\Controllers\API\Admin\AdminsController@index                      | auth.basic.once,admin      |
|        | POST     | api/admin/admins                                      | api.admin.admins.store                | App\Http\Controllers\API\Admin\AdminsController@store                      | auth.basic.once,admin      |
|        | DELETE   | api/admin/admins/{admins}                             | api.admin.admins.destroy              | App\Http\Controllers\API\Admin\AdminsController@destroy                    | auth.basic.once,admin      |
|        | PUT      | api/admin/admins/{admins}                             | api.admin.admins.update               | App\Http\Controllers\API\Admin\AdminsController@update                     | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/admins/{admins}                             | api.admin.admins.show                 | App\Http\Controllers\API\Admin\AdminsController@show                       | auth.basic.once,admin      |
|        | PATCH    | api/admin/admins/{admins}                             |                                       | App\Http\Controllers\API\Admin\AdminsController@update                     | auth.basic.once,admin      |
|        | POST     | api/admin/dispatchers                                 | api.admin.dispatchers.store           | App\Http\Controllers\API\Admin\DispatchersController@store                 | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/dispatchers                                 | api.admin.dispatchers.index           | App\Http\Controllers\API\Admin\DispatchersController@index                 | auth.basic.once,admin      |
|        | DELETE   | api/admin/dispatchers/{dispatchers}                   | api.admin.dispatchers.destroy         | App\Http\Controllers\API\Admin\DispatchersController@destroy               | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/dispatchers/{dispatchers}                   | api.admin.dispatchers.show            | App\Http\Controllers\API\Admin\DispatchersController@show                  | auth.basic.once,admin      |
|        | PATCH    | api/admin/dispatchers/{dispatchers}                   |                                       | App\Http\Controllers\API\Admin\DispatchersController@update                | auth.basic.once,admin      |
|        | PUT      | api/admin/dispatchers/{dispatchers}                   | api.admin.dispatchers.update          | App\Http\Controllers\API\Admin\DispatchersController@update                | auth.basic.once,admin      |
|        | POST     | api/admin/dispatchers/{dispatchers}/drivers           | api.admin.dispatchers.drivers.store   | App\Http\Controllers\API\Admin\DispatcherDriversController@store           | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/dispatchers/{dispatchers}/drivers           | api.admin.dispatchers.drivers.index   | App\Http\Controllers\API\Admin\DispatcherDriversController@index           | auth.basic.once,admin      |
|        | DELETE   | api/admin/dispatchers/{dispatchers}/drivers/{drivers} | api.admin.dispatchers.drivers.destroy | App\Http\Controllers\API\Admin\DispatcherDriversController@destroy         | auth.basic.once,admin      |
|        | PUT      | api/admin/dispatchers/{dispatchers}/drivers/{drivers} | api.admin.dispatchers.drivers.update  | App\Http\Controllers\API\Admin\DispatcherDriversController@update          | auth.basic.once,admin      |
|        | PATCH    | api/admin/dispatchers/{dispatchers}/drivers/{drivers} |                                       | App\Http\Controllers\API\Admin\DispatcherDriversController@update          | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/dispatchers/{dispatchers}/drivers/{drivers} | api.admin.dispatchers.drivers.show    | App\Http\Controllers\API\Admin\DispatcherDriversController@show            | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/drivers                                     | api.admin.drivers.index               | App\Http\Controllers\API\Admin\DriversController@index                     | auth.basic.once,admin      |
|        | PATCH    | api/admin/drivers/{drivers}                           |                                       | App\Http\Controllers\API\Admin\DriversController@update                    | auth.basic.once,admin      |
|        | DELETE   | api/admin/drivers/{drivers}                           | api.admin.drivers.destroy             | App\Http\Controllers\API\Admin\DriversController@destroy                   | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/drivers/{drivers}                           | api.admin.drivers.show                | App\Http\Controllers\API\Admin\DriversController@show                      | auth.basic.once,admin      |
|        | PUT      | api/admin/drivers/{drivers}                           | api.admin.drivers.update              | App\Http\Controllers\API\Admin\DriversController@update                    | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/drivers/{drivers}/orders                    | api.admin.drivers.orders.index        | App\Http\Controllers\API\Admin\DriverOrdersController@index                | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/drivers/{drivers}/orders/{orders}           | api.admin.drivers.orders.show         | App\Http\Controllers\API\Admin\DriverOrdersController@show                 | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/drivers/{driver}/orders/{order}/statuses    |                                       | App\Http\Controllers\API\Admin\OrderStatusesController@driverOrderStatuses | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/orders                                      | api.admin.orders.index                | App\Http\Controllers\API\Admin\OrdersController@index                      | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/orders/{orders}                             | api.admin.orders.show                 | App\Http\Controllers\API\Admin\OrdersController@show                       | auth.basic.once,admin      |
|        | GET|HEAD | api/admin/orders/{orders}/statuses                    | api.admin.orders.statuses.index       | App\Http\Controllers\API\Admin\OrderStatusesController@index               | auth.basic.once,admin      |
|        | POST     | api/dispatcher/drivers                                | api.dispatcher.drivers.store          | App\Http\Controllers\API\Dispatcher\DriversController@store                | auth.basic.once,dispatcher |
|        | GET|HEAD | api/dispatcher/drivers                                | api.dispatcher.drivers.index          | App\Http\Controllers\API\Dispatcher\DriversController@index                | auth.basic.once,dispatcher |
|        | PATCH    | api/dispatcher/drivers/{drivers}                      |                                       | App\Http\Controllers\API\Dispatcher\DriversController@update               | auth.basic.once,dispatcher |
|        | DELETE   | api/dispatcher/drivers/{drivers}                      | api.dispatcher.drivers.destroy        | App\Http\Controllers\API\Dispatcher\DriversController@destroy              | auth.basic.once,dispatcher |
|        | PUT      | api/dispatcher/drivers/{drivers}                      | api.dispatcher.drivers.update         | App\Http\Controllers\API\Dispatcher\DriversController@update               | auth.basic.once,dispatcher |
|        | GET|HEAD | api/dispatcher/drivers/{drivers}                      | api.dispatcher.drivers.show           | App\Http\Controllers\API\Dispatcher\DriversController@show                 | auth.basic.once,dispatcher |
|        | GET|HEAD | api/dispatcher/drivers/{drivers}/orders               | api.dispatcher.drivers.orders.index   | App\Http\Controllers\API\Dispatcher\DriverOrdersController@index           | auth.basic.once,dispatcher |
|        | GET|HEAD | api/dispatcher/drivers/{drivers}/orders/{orders}      | api.dispatcher.drivers.orders.show    | App\Http\Controllers\API\Dispatcher\DriverOrdersController@show            | auth.basic.once,dispatcher |
|        | GET|HEAD | api/dispatcher/orders                                 | api.dispatcher.orders.index           | App\Http\Controllers\API\Dispatcher\OrderStatusesController@index          | auth.basic.once,dispatcher |
|        | POST     | api/dispatcher/orders                                 | api.dispatcher.orders.store           | App\Http\Controllers\API\Dispatcher\OrdersController@store                 | auth.basic.once,dispatcher |
|        | GET|HEAD | api/dispatcher/orders/{orders}                        | api.dispatcher.orders.show            | App\Http\Controllers\API\Dispatcher\OrdersController@show                  | auth.basic.once,dispatcher |
|        | DELETE   | api/dispatcher/orders/{orders}                        | api.dispatcher.orders.destroy         | App\Http\Controllers\API\Dispatcher\OrdersController@destroy               | auth.basic.once,dispatcher |
|        | PATCH    | api/dispatcher/orders/{orders}                        |                                       | App\Http\Controllers\API\Dispatcher\OrdersController@update                | auth.basic.once,dispatcher |
|        | PUT      | api/dispatcher/orders/{orders}                        | api.dispatcher.orders.update          | App\Http\Controllers\API\Dispatcher\OrdersController@update                | auth.basic.once,dispatcher |
|        | GET|HEAD | api/driver/orders                                     | api.driver.orders.index               | App\Http\Controllers\API\Driver\OrdersController@index                     | auth.basic.once,driver     |
|        | PUT      | api/driver/orders/{orders}                            | api.driver.orders.update              | App\Http\Controllers\API\Driver\OrdersController@update                    | auth.basic.once,driver     |
|        | PATCH    | api/driver/orders/{orders}                            |                                       | App\Http\Controllers\API\Driver\OrdersController@update                    | auth.basic.once,driver     |
|        | GET|HEAD | api/driver/orders/{orders}/statuses                   | api.driver.orders.statuses.index      | App\Http\Controllers\API\Driver\OrderStatusesController@index              | auth.basic.once,driver     |
|        | POST     | api/driver/orders/{orders}/statuses                   | api.driver.orders.statuses.store      | App\Http\Controllers\API\Driver\LocationsController@store                  | auth.basic.once,driver     |
+--------+----------+-------------------------------------------------------+---------------------------------------+----------------------------------------------------------------------------+----------------------------+
*/
Route::group(['prefix' => 'api', 'middleware' => 'auth.basic.once'], function () {
    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::resource('orders', 'API\Admin\OrdersController', ['only' => ['index', 'show']]);
        Route::resource('orders.statuses', 'API\Admin\OrderStatusesController', ['only' => ['index']]);
        Route::resource('admins', 'API\Admin\AdminsController', ['except' => ['edit', 'create']]);
        Route::resource('dispatchers', 'API\Admin\DispatchersController', ['except' => ['edit', 'create']]);
        Route::resource('dispatchers.drivers', 'API\Admin\DispatcherDriversController',
            ['except' => ['edit', 'create']]);
        Route::resource('drivers', 'API\Admin\DriversController', ['except' => ['edit', 'create', 'store']]);
        Route::resource('drivers.orders', 'API\Admin\DriverOrdersController', ['only' => ['index', 'show']]);
        Route::get('drivers/{driver}/orders/{order}/statuses', 'API\Admin\OrderStatusesController@driverOrderStatuses');
    });
    Route::group(['middleware' => 'dispatcher', 'prefix' => 'dispatcher'], function () {
        Route::resource('orders', 'API\Dispatcher\OrdersController', ['except' => ['create', 'edit']]);
        Route::resource('orders', 'API\Dispatcher\OrderStatusesController', ['only' => 'index']);
        Route::resource('drivers', 'API\Dispatcher\DriversController', ['except' => ['create', 'edit']]);
        Route::resource('drivers.orders', 'API\Dispatcher\DriverOrdersController', ['only' => ['index', 'show']]);
    });
    Route::group(['middleware' => 'driver', 'prefix' => 'driver'], function () {
        Route::resource('orders', 'API\Driver\OrdersController', ['only' => ['index', 'update']]);
        Route::resource('orders.statuses', 'API\Driver\OrderStatusesController', ['only' => ['index']]);
        Route::resource('orders.statuses', 'API\Driver\LocationsController', ['only' => ['store']]);
    });
});

Route::group(['prefix' => 'frontend'], function () {
    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
        Route::resource('order', 'Front\Admin\OrderController');
        Route::resource('user', 'Front\Admin\UserController');
    });
    Route::group(['middleware' => 'dispatcher', 'prefix' => 'dispatcher'], function () {
        Route::resource('user', 'Front\Dispatcher\UserController');
        Route::resource('order', 'Front\Dispatcher\OrderController');
    });
    Route::group(['middleware' => 'driver', 'prefix' => 'driver'], function () {
        Route::resource('order', 'Front\Driver\OrderController');
    });
    Route::group(['middleware' => 'auth.basic'], function () {
        Route::resource('profile', 'Front\ProfileController');
    });
});
Route::get('/', function () {
    return view('welcome');
});
