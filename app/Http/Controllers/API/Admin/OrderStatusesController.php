<?php

namespace App\Http\Controllers\API\Admin;

use App\User;
use App\Order;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use App\Http\Controllers\ApiController;
use App\GK\Transformers\StatusTransformer;

class OrderStatusesController extends ApiController
{
    /**
     * @var StatusTransformer
     */
    private $statusTransformer;

    /**
     * OrderStatusesController constructor.
     * @param StatusTransformer $statusTransformer
     * @param JsonRespond $jsonRespond
     */
    public function __construct(StatusTransformer $statusTransformer, JsonRespond $jsonRespond)
    {
        parent::__construct($jsonRespond);
        $this->statusTransformer = $statusTransformer;
        $this->jsonRespond       = $jsonRespond;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Order $order)
    {
        $statuses = $order->statusHistory()->latest()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->statusTransformer, $statuses);
    }

    /**
     * @param User $driver
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function driverOrderStatuses(User $driver, Order $order)
    {
        $statuses = $order->statusHistory()->latest()->createdByUser($driver)->paginate(20);

        return $this->jsonRespond->respondPaginator($this->statusTransformer, $statuses);
    }
}
