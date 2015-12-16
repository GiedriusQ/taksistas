<?php

namespace App\Http\Controllers\API\Dispatcher;

use App\Order;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use App\Http\Controllers\ApiController;
use App\GK\Transformers\OrderTransformer;
use App\GK\Transformers\StatusTransformer;

class OrderStatusesController extends ApiController
{
    /**
     * @var OrderTransformer
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
     * @return \Illuminate\Http\Response
     */
    public function index(Order $order)
    {
        $statuses = $order->statusHistory()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->statusTransformer, $statuses);
    }
}
