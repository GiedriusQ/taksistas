<?php

namespace App\Http\Controllers\API\Driver;

use App\Order;
use App\StatusHistory;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

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

        return response()->json(['orders' => $orders]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('status_history')->find($id);

        return response()->json(['order' => $order]);
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
        $rules = [
            'status' => 'required|in:' . implode(',', array_keys(Config::get('statuses')))
        ];
        $this->validate($request, $rules);
        $order = Order::findOrFail($id);
        $order->update([
            'status' => $request->get('status')
        ]);
        $order->status_history->save(new StatusHistory([
            'status'  => $request->get('status'),
            'user_id' => Auth::user()->id
        ]));

        return response()->json(['order' => $order]);
    }
}
