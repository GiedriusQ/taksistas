<?php

namespace App\Http\Controllers\API\Dispatcher;

use App\GK\Json\JsonRespond;
use App\GK\Transformers\UserTransformer;
use App\Http\Requests\Dispatcher\UpdateUserRequest;
use App\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ApiController;

class DriversController extends ApiController
{
    protected $userTransformer;
    protected $users;
    protected $user;

    /**
     * DriversController constructor.
     * @param AuthManager $auth
     * @param User $users
     * @param JsonRespond $jsonRespond
     * @param UserTransformer $userTransformer
     */
    public function __construct(
        AuthManager $auth,
        User $users,
        JsonRespond $jsonRespond,
        UserTransformer $userTransformer
    ) {
        $this->user            = $auth->user();
        $this->userTransformer = $userTransformer;
        $this->users           = $users;
        parent::__construct($jsonRespond);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = $this->users->paginate(20);

        return $this->jsonRespond->respondPaginator($this->userTransformer, $drivers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $driver = $this->user->createDriverForDispatcher($request->all());

        return $this->jsonRespond->respondModel($this->userTransformer, $driver);
    }

    /**
     * Display the specified resource.
     *
     * @param User $driver
     * @return \Illuminate\Http\Response
     */
    public function show(User $driver)
    {
        return $this->jsonRespond->respondModel($this->userTransformer, $driver);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $driver
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $driver)
    {
        $driver->update($request->all());

        return $this->jsonRespond->respondModel($this->userTransformer, $driver);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $driver)
    {
        $driver->delete();

        return $this->jsonRespond->respondDelete();
    }
}
