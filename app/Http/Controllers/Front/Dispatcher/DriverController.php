<?php

namespace App\Http\Controllers\Front\Dispatcher;

use App\GK\Utilities\API;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DriverController extends Controller
{
    /**
     * @var API
     */
    private $API;

    /**
     * UserController constructor.
     * @param API $API
     */
    public function __construct(API $API)
    {
        $this->API = $API;
    }

    public function getDrivers(Request $request)
    {
        $drivers = $this->API->call(API::dispatcher_drivers . '?page=' . $request->get('page', 1));
        if ($drivers->status_code != 200) {
            return redirect()->back()->withErrors($drivers->error);
        }

        return view('dispatcher.drivers.index', compact('drivers'));
    }

    public function getShowDriver($id)
    {
        $driver = $this->API->call(API::dispatcher_drivers . "/{$id}");
        if ($driver->status_code != 200) {
            return redirect()->back()->withErrors($driver->error);
        }
        $driver = $driver->data;

        $orders = $this->API->call(API::dispatcher_drivers . "/{$id}/orders");
        if ($orders->status_code != 200) {
            return redirect()->back()->withErrors($orders->error);
        }

        return view('dispatcher.drivers.show', compact('driver', 'orders'));
    }

    public function getCreateDriver()
    {
        return view('dispatcher.drivers.create');
    }

    public function postCreateDriver(Request $request)
    {
        $order = $this->API->call(API::dispatcher_drivers, 'POST', $request->all());
        if ($order->status_code != 201) {
            return redirect()->back()->withErrors($order->error);
        }

        return redirect()->action('Front\Dispatcher\DriverController@getDrivers')->withSuccess('Driver created successfully');
    }

    public function getEditDriver($id)
    {
        $driver = $this->API->call(API::dispatcher_drivers . "/{$id}");
        if ($driver->status_code != 200) {
            return redirect()->back()->withErrors($driver->error);
        }
        $driver = $driver->data;

        return view('dispatcher.drivers.edit', compact('driver'));
    }

    public function postEditDriver(Request $request, $id)
    {
        $order = $this->API->call(API::dispatcher_drivers . "/{$id}", 'PUT', $request->all());
        if ($order->status_code != 200) {
            return redirect()->back()->withErrors($order->error);
        }

        return redirect()->action('Front\Dispatcher\DriverController@getDrivers')->withSuccess('Driver updated successfully');
    }

    public function getDeleteDriver($id)
    {
        $order = $this->API->call(API::dispatcher_drivers . "/{$id}", 'DELETE');
        if ($order->status_code != 200) {
            return redirect()->back()->withErrors($order->error);
        }

        return redirect()->action('Front\Dispatcher\DriverController@getDrivers')->withSuccess('Driver deleted successfully');
    }
}
