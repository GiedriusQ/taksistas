<?php

namespace App\Http\Controllers\API\Dispatcher;

use App\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Auth::user()->orders;

        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'driver_id' => 'sometimes|exists:users,id,type,2',
            'from'      => 'required|max:150',
            'to'        => 'required|max:150',
            'client'    => 'required|max:100'
        ];
        $this->validate($request, $rules);
        $order = Order::create($request->only(['from','to','client']));
        Auth::user()->orders()->associate($order);

        //gmaps, bing magija  from/to -> lat lng

        return response()->json($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with(['driver', 'status_history'])->findOrFail($id);

        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
