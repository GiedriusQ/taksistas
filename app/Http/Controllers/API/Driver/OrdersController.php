<?php

namespace App\Http\Controllers\API\Driver;

use App\Order;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use Illuminate\Auth\AuthManager;
use App\Http\Controllers\ApiController;
use App\GK\Transformers\OrderTransformer;
use App\Http\Requests\Driver\UpdateOrderRequest;

class OrdersController extends ApiController
{

    /**
     * @var OrderTransformer
     */
    private $orderTransformer;
    private $user;

    public function __construct(AuthManager $auth, OrderTransformer $orderTransformer, JsonRespond $jsonRespond)
    {
        parent::__construct($jsonRespond);
        $this->user             = $auth->user();
        $this->orderTransformer = $orderTransformer;
        $this->jsonRespond      = $jsonRespond;
    }

    public function index()
    {
        $orders = $this->user->orders()->latest()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->orderTransformer, $orders);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->all());
        $this->user->assignNearestOrderIfAvailable();

        return $this->jsonRespond->respondModel($this->orderTransformer, $order);
    }

    public function show(Order $order)
    {
        return $this->jsonRespond->respondModel($this->orderTransformer, $order);
    }

}
