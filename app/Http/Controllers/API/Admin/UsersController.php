<?php

namespace App\Http\Controllers\API\Admin;

use App\User;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\ApiController;
use App\GK\Transformers\UserTransformer;

class UsersController extends ApiController
{
    protected $userTransformer;
    protected $users;

    /**
     * AdminsController constructor.
     * @param User $users
     * @param JsonRespond $jsonRespond
     * @param UserTransformer $userTransformer
     */
    public function __construct(User $users, JsonRespond $jsonRespond, UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
        $this->users           = $users;
        parent::__construct($jsonRespond);
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->users->paginate(20);

        return $this->jsonRespond->respondPaginator($this->userTransformer, $users);
    }

    /**
     * Display a listing of the admins.
     *
     * @return \Illuminate\Http\Response
     */
    public function admins()
    {
        $admins = $this->users->isAdmin()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->userTransformer, $admins);
    }

    /**
     * Display a listing of the dispatchers.
     *
     * @return \Illuminate\Http\Response
     */
    public function dispatchers()
    {
        $dispatchers = $this->users->isDispatcher()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->userTransformer, $dispatchers);
    }

    /**
     * Display a listing of the drivers.
     *
     * @return \Illuminate\Http\Response
     */
    public function drivers()
    {
        $drivers = $this->users->isDriver()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->userTransformer, $drivers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeAdmins(AdminRequest $request)
    {
        $admin = $this->users->createAdmin($request->all());

        return $this->jsonRespond->respondModelStore($this->userTransformer, $admin);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeDispatchers(AdminRequest $request)
    {
        $dispatcher = $this->users->createDispatcher($request->all());

        return $this->jsonRespond->respondModelStore($this->userTransformer, $dispatcher);
    }

    /**
     * Display the specified user.
     *
     * @param User $admin
     * @return \Illuminate\Http\Response
     */
    public function show(User $admin)
    {
        return $this->jsonRespond->respondModel($this->userTransformer, $admin);
    }

    /**
     * Update the specified user in storage.
     *
     * @param AdminRequest $request
     * @param User $admin
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, User $admin)
    {
        $admin->update($request->all());

        return $this->jsonRespond->respondModel($this->userTransformer, $admin);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $admin
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $admin)
    {
        $admin->delete();

        return $this->jsonRespond->respondDelete();
    }
}
