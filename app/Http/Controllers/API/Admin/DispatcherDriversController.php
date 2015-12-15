<?php

namespace App\Http\Controllers\API\Admin;

use App\User;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use App\Http\Controllers\ApiController;
use App\GK\Transformers\UserTransformer;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;

class DispatcherDriversController extends ApiController
{
    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * DispatcherDriversController constructor.
     * @param UserTransformer $userTransformer
     * @param JsonRespond $jsonRespond
     */
    public function __construct(UserTransformer $userTransformer, JsonRespond $jsonRespond)
    {
        parent::__construct($jsonRespond);
        $this->jsonRespond     = $jsonRespond;
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @param User $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function index(User $dispatcher)
    {
        $drivers = $dispatcher->drivers()->paginate(20);

        return $this->respondUserPaginator($this->userTransformer, $drivers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request, User $dispatcher)
    {
        $driver = $dispatcher->createDriverForDispatcher($request->all());

        return $this->respondUserModel($this->userTransformer, $driver);
    }

    /**
     * Display the specified resource.
     *
     * @param User $dispatcher
     * @param User $driver
     * @return \Illuminate\Http\Response
     */
    public function show(User $dispatcher, User $driver)
    {
        return $this->respondUserModel($this->userTransformer, $driver);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $dispatcher
     * @param User $driver
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $dispatcher, User $driver)
    {
        $driver->update($request->all());

        return $this->respondUserModel($this->userTransformer, $driver);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $driver
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $driver)
    {
        $driver->delete();

        return $this->jsonRespond->respondDelete();
    }
}
