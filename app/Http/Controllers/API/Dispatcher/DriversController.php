<?php

namespace App\Http\Controllers\API\Dispatcher;

use App\User;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use Illuminate\Auth\AuthManager;
use App\Http\Controllers\ApiController;
use App\GK\Transformers\UserTransformer;
use App\Http\Requests\Dispatcher\UserRequest;

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
        $drivers = $this->user->drivers()->latest()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->userTransformer, $drivers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $driver = $this->user->createDriverForDispatcher($request->all());

        return $this->jsonRespond->respondModelStore($this->userTransformer, $driver);
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
     * @param UserRequest $request
     * @param User $driver
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $driver)
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
