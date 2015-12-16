<?php

namespace App\Http\Controllers;

use App\GK\Json\JsonRespond;

class ApiController extends Controller
{
    /**
     * @var JsonRespond
     */
    protected $jsonRespond;

    public function __construct(JsonRespond $jsonRespond)
    {
        $this->jsonRespond = $jsonRespond;
    }
}