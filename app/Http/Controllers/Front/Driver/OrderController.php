<?php

namespace App\Http\Controllers\Front\Driver;

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
        $orders = $this->API->call(API::driver_orders . '?page=' . $request->get('page', 1));
        if ($orders->status_code != 200) {
            return redirect()->back()->withErrors($orders->error);
        }

        return view('driver.orders.index', compact('orders'));
    }

    public function getShowOrder($id)
    {
        $order = $this->API->call(API::driver_orders . "/{$id}");
        if ($order->status_code != 200) {
            return redirect()->back()->withErrors($order->error);
        }
        $order = $order->data;

        return view('driver.orders.show', compact('order'));
    }

    public function getEditOrder($id)
    {
        $order = $this->API->call(API::driver_orders . "/{$id}");
        if ($order->status_code != 200) {
            return redirect()->back()->withErrors($order->error);
        }
        $order         = $order->data;
        $order->from   = $order->take_from;
        $order->to     = $order->transport_to;
        $order->status = array_keys(config('statuses'), $order->status)[0];

        return view('driver.orders.edit', compact('order'));
    }

    public function postEditOrder(Request $request, $id)
    {
        $order = $this->API->call(API::driver_orders . "/{$id}", 'PUT', $request->all());
        if ($order->status_code != 200) {
            return redirect()->back()->withErrors($order->error);
        }

        return redirect()->action('Front\Driver\OrderController@getOrders')->withSuccess('Order updated successfully');
    }
}
