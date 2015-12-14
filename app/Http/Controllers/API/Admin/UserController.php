<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->get();

        return response()->json(['users' => $users->keyBy('id')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->except('type') + ['type' => 1]);

        return response()->json(['user' => $user]);
    }

    public function showDispatcher(User $dispatcher)
    {
        return response()->json(['dispatcher' => $dispatcher]);
    }

    public function showDriver(User $driver)
    {
        return response()->json(['driver' => $driver]);
    }

    public function showOrders(User $user)
    {
        return response()->json(['orders' => $user->orders]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest|Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->all());

        return response()->json(['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['success' => 'User deleted successfully']);
    }
}
