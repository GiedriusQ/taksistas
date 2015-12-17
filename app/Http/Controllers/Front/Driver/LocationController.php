<?php

namespace App\Http\Controllers\Front\Driver;

use App\GK\Utilities\API;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    /**
     * @var API
     */
    private $API;

    /**
     * UserController constructor.
     * @param API $API
     */
    public function __construct(API $API)
    {
        $this->API = $API;
    }

    public function getLocations()
    {
        $locations = $this->API->call(API::driver_locations);
        if ($locations->status_code != 200) {
            return redirect()->back()->withErrors($locations->error);
        }
        $locations = $locations->data;

        return view('driver.locations.index', compact('locations'));
    }
}
