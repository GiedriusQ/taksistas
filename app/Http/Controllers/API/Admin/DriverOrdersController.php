<?php

namespace App\Http\Controllers\API\Admin;

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
     * @param OrderTransformer $statusTransformer
     * @param JsonRespond $jsonRespond
     */
    public function __construct(OrderTransformer $statusTransformer, JsonRespond $jsonRespond)
    {
        parent::__construct($jsonRespond);
        $this->orderTransformer = $statusTransformer;
        $this->jsonRespond      = $jsonRespond;
    }

    /**
     * Display a listing of the resource.
     *
     * @param User $driver
     * @return \Illuminate\Http\Response
     */
    public function index(User $driver)
    {
        $users = $driver->orders()->latest()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->orderTransformer, $users);
    }

    /**
     * Display the specified resource.
     *
     * @param User $driver
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(User $driver, Order $order)
    {
        $data = $this->orderTransformer->transformModel($order);

        return $this->jsonRespond->respondWithData($data);
    }
}
