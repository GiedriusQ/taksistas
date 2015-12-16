<?php

namespace App\Http\Controllers\API\Driver;

use App\Order;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use App\Http\Controllers\ApiController;
use App\GK\Transformers\StatusTransformer;
use App\Http\Requests\Driver\StoreStatusRequest;
use Illuminate\Auth\AuthManager;

class OrderStatusesController extends ApiController
{
    /**
     * @var StatusTransformer
     */
    private $statusTransformer;
    /**
     * @var AuthManager
     */
    private $user;

    /**
     * OrderStatusesController constructor.
     * @param AuthManager $authManager
     * @param StatusTransformer $statusTransformer
     * @param JsonRespond $jsonRespond
     */
    public function __construct(
        AuthManager $authManager,
        StatusTransformer $statusTransformer,
        JsonRespond $jsonRespond
    ) {
        parent::__construct($jsonRespond);
        $this->statusTransformer = $statusTransformer;
        $this->jsonRespond       = $jsonRespond;
        $this->user              = $authManager->user();
    }

    public function store(StoreStatusRequest $request, Order $order)
    {
        $status = $order->setStatus($this->user, $request->get('status'));

        return $this->jsonRespond->respondModelStore($this->statusTransformer, $status);
    }
}
