<?php

namespace App\Http\Controllers\API\Driver;

use App\DriverLocation;
use App\GK\Json\JsonRespond;
use App\GK\Transformers\DriverLocationTransformer;
use App\Order;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ApiController;

class LocationsController extends ApiController
{
    /**
     * @var AuthManager
     */
    private $user;
    /**
     * @var DriverLocationTransformer
     */
    private $driverLocationTransformer;

    public function __construct(
        DriverLocationTransformer $driverLocationTransformer,
        AuthManager $authManager,
        JsonRespond $jsonRespond
    ) {
        parent::__construct($jsonRespond);
        $this->user                      = $authManager->user();
        $this->jsonRespond               = $jsonRespond;
        $this->driverLocationTransformer = $driverLocationTransformer;
    }

    public function index()
    {
        $location = $this->user->locations()->first();

        return $this->jsonRespond->respondModel($this->driverLocationTransformer, $location);
    }

    public function store(Request $request)
    {
        $location = $this->user->locations()->save(new DriverLocation($request->all()));

        return $this->jsonRespond->respondModelStore($this->driverLocationTransformer, $location);
    }
}
