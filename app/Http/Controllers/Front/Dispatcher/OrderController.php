<?php

namespace App\Http\Controllers\Front\Dispatcher;

use App\GK\Utilities\API;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
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

    public function getOrders(Request $request)
    {
        $orders = $this->API->call(API::dispatcher_orders . '?page=' . $request->get('page', 1));
        if ($orders->status_code != 200) {
            return redirect()->back()->withErrors($orders->error);
        }

        return view('dispatcher.orders.index', compact('orders'));
    }

    public function getShowOrder($id)
    {
        $order = $this->API->call(API::dispatcher_orders . "/{$id}");
        if ($order->status_code != 200) {
            return redirect()->back()->withErrors($order->error);
        }
        $order  = $order->data;
        $driver = null;
        if ($order->driver_id != null) {
            $driver = $this->API->call(API::dispatcher_drivers . "/{$order->driver_id}");
            if ($driver->status_code != 200) {
                return redirect()->back()->withErrors($driver->error);
            }
            $driver = $driver->data;
        }

        return view('dispatcher.orders.show', compact('order', 'driver'));
    }

    public function getCreateOrder()
    {
        return view('dispatcher.orders.create');
    }

    public function postCreateOrder(Request $request)
    {
        $order = $this->API->call(API::dispatcher_orders, 'POST', $request->all());
        if ($order->status_code != 201) {
            return redirect()->back()->withErrors($order->error);
        }

        return redirect()->action('Front\Dispatcher\OrderController@getOrders');
    }

    public function getEditOrder($id)
    {
        $order = $this->API->call(API::dispatcher_orders . "/{$id}");
        if ($order->status_code != 200) {
            return redirect()->back()->withErrors($order->error);
        }
        $order         = $order->data;
        $order->from   = $order->take_from;
        $order->to     = $order->transport_to;
        $order->status = array_keys(config('statuses'), $order->status)[0];

        return view('dispatcher.orders.edit', compact('order'));
    }

    public function postEditOrder(Request $request, $id)
    {
        $order = $this->API->call(API::dispatcher_orders . "/{$id}", 'PUT', $request->all());
        if ($order->status_code != 200) {
            return redirect()->back()->withErrors($order->error);
        }

        return redirect()->action('Front\Dispatcher\OrderController@getOrders');
    }

    public function getDeleteOrder($id)
    {
        $order = $this->API->call(API::dispatcher_orders . "/{$id}", 'DELETE');
        if ($order->status_code != 200) {
            return redirect()->back()->withErrors($order->error);
        }

        return redirect()->action('Front\Dispatcher\OrderController@getOrders');
    }
}
