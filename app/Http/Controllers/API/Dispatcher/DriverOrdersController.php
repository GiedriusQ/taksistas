<?php

namespace App\Http\Controllers\API\Dispatcher;

use App\User;
use App\Order;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use App\Http\Controllers\ApiController;
use App\GK\Transformers\OrderTransformer;

class DriverOrdersController extends ApiController
{
    /**
     * @var OrderTransformer
     */
    private $orderTransformer;

    /**
     * DriverOrdersController constructor.
     * @param OrderTransformer $orderTransformer
     * @param JsonRespond $jsonRespond
     */
    public function __construct(OrderTransformer $orderTransformer, JsonRespond $jsonRespond)
    {
        parent::__construct($jsonRespond);
        $this->orderTransformer = $orderTransformer;
        $this->jsonRespond      = $jsonRespond;
    }

    public function index(User $driver)
    {
        $orders = $driver->orders()->latest()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->orderTransformer, $orders);
    }

    public function show(User $driver, Order $order)
    {
        return $this->jsonRespond->respondModel($this->orderTransformer, $order);
    }
}
