<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use App\GK\Utilities\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\LoginRequest;

class HomeController extends Controller
{
    public function getHome()
    {
        return view('layout');
    }
}
