<?php

namespace App\Http\Controllers\Front\Admin;

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

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getOrders(Request $request)
    {
        $orders = $this->API->call(API::admin_orders . '?page=' . $request->get('page', 1));

        return view('admin.orders.index', compact('orders'));
    }

    public function getShowOrder($order_id)
    {
        $order = $this->API->call(API::admin_orders . "/{$order_id}");
        if ($order->status_code != 200) {
            return redirect()->back()->withErrors($order->error);
        }
        $order = $order->data;

        return view('admin.orders.show', compact('order'));
    }
}
