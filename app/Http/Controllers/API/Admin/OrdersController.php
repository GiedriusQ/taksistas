<?php

namespace App\Http\Controllers\API\Admin;

use App\Order;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use App\Http\Controllers\ApiController;
use App\GK\Transformers\OrderTransformer;

class OrdersController extends ApiController
{
    protected $orderTransformer;
    protected $orders;

    /**
     * AdminsController constructor.
     * @param Order $orders
     * @param JsonRespond $jsonRespond
     * @param OrderTransformer $userTransformer
     */
    public function __construct(Order $orders, JsonRespond $jsonRespond, OrderTransformer $userTransformer)
    {
        $this->orderTransformer = $userTransformer;
        $this->orders           = $orders;
        parent::__construct($jsonRespond);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orders->latest()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->orderTransformer, $orders);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $data = $this->orderTransformer->transformModel($order);

        return $this->jsonRespond->respondWithData($data);
    }
}
