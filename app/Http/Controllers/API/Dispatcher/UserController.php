<?php

namespace App\Http\Controllers\API\Dispatcher;

use App\User;
use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = Auth::user()->drivers;

        return response()->json(['drivers' => $drivers->keyBy('id')]);
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
            'name'     => 'required|min:3|max:60|unique:profiles,name',
            'city'     => 'required|min:3|max:60',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6'
        ];
        $this->validate($request, $rules);
        $user = User::create([
            'name'     => $request->get('name'),
            'email'    => $request->get('email'),
            'type'     => 2,
            'password' => bcrypt($request->get('password')),
        ]);

        return response()->json(['user' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver = User::findOrFail($id);

        return response()->json(['driver' => $driver]);
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
            'name'     => 'required|min:3|max:60|unique:profiles,name',
            'city'     => 'required|min:3|max:60',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6'
        ];
        $this->validate($request, $rules);
        $user = User::findOrFail($id);
        $user->update([
            'email'    => $request->get('email'),
            'type'     => 2,
            'password' => bcrypt($request->get('password')),
        ]);

        return response()->json(['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json(['success' => 'Driver deleted successfully']);
    }
}
