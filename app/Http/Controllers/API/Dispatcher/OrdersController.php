<?php

namespace App\Http\Controllers\API\Dispatcher;

use App\Order;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use Illuminate\Auth\AuthManager;
use App\Http\Controllers\ApiController;
use App\GK\Transformers\OrderTransformer;
use App\Http\Requests\Dispatcher\OrderRequest;

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
     * @var AuthManager
     */
    private $user;

    /**
     * OrdersController constructor.
     * @param AuthManager $authManager
     * @param Order $orders
     * @param OrderTransformer $orderTransformer
     * @param JsonRespond $jsonRespond
     */
    public function __construct(
        AuthManager $authManager,
        Order $orders,
        OrderTransformer $orderTransformer,
        JsonRespond $jsonRespond
    ) {
        parent::__construct($jsonRespond);
        $this->orders           = $orders;
        $this->orderTransformer = $orderTransformer;
        $this->jsonRespond      = $jsonRespond;
        $this->user             = $authManager->user();
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
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $order = $this->user->createOrder(['status' => 0] + $request->all());
        $order->load('statusHistory');
        $order->assignNearestDriver();

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
     * @param OrderRequest $request
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
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
