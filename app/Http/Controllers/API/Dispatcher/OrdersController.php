<?php

namespace App\Http\Controllers\API\Dispatcher;

use App\Order;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\GK\Transformers\OrderTransformer;

class OrdersController extends ApiController
{

    /**
     * @var OrderTransformer
     */
    private $orderTransformer;
    /**
     * @var Order
     */
    private $orders;

    /**
     * OrdersController constructor.
     * @param Order $orders
     * @param OrderTransformer $orderTransformer
     * @param JsonRespond $jsonRespond
     */
    public function __construct(Order $orders, OrderTransformer $orderTransformer, JsonRespond $jsonRespond)
    {
        parent::__construct($jsonRespond);
        $this->orders           = $orders;
        $this->orderTransformer = $orderTransformer;
        $this->jsonRespond      = $jsonRespond;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orders->paginate(20);

        return $this->jsonRespond->respondPaginator($this->orderTransformer, $orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = $this->orders->create($request->all());

        return $this->jsonRespond->respondModelStore($this->orderTransformer, $order);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return $this->jsonRespond->respondModel($this->orderTransformer, $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->update($request->all());

        return $this->jsonRespond->respondUpdate($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return $this->jsonRespond->respondDelete();
    }
}
