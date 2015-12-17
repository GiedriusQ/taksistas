<?php

namespace App\Http\Controllers\API\Admin;

use App\User;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use App\Http\Controllers\ApiController;
use App\GK\Transformers\UserTransformer;
use App\Http\Requests\Admin\AdminRequest;
use App\GK\Transformers\UserListTransformer;

class UsersController extends ApiController
{
    protected $userTransformer;
    protected $users;
    /**
     * @var UserListTransformer
     */
    private $userListTransformer;

    /**
     * AdminsController constructor.
     * @param UserListTransformer $userListTransformer
     * @param User $users
     * @param JsonRespond $jsonRespond
     * @param UserTransformer $userTransformer
     */
    public function __construct(
        UserListTransformer $userListTransformer,
        User $users,
        JsonRespond $jsonRespond,
        UserTransformer $userTransformer
    ) {
        $this->userTransformer     = $userTransformer;
        $this->users               = $users;
        $this->userListTransformer = $userListTransformer;
        parent::__construct($jsonRespond);
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->users->latest()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->userTransformer, $users);
    }

    public function admins()
    {
        $admins = $this->users->isAdmin()->latest()->get(['name', 'id']);

        return $this->jsonRespond->respondCollection($this->userListTransformer, $admins);
    }

    public function dispatchers()
    {
        $admins = $this->users->isDispatcher()->latest()->get(['name', 'id']);

        return $this->jsonRespond->respondCollection($this->userListTransformer, $admins);
    }

    public function drivers()
    {
        $admins = $this->users->isDriver()->latest()->get(['name', 'id']);

        return $this->jsonRespond->respondCollection($this->userListTransformer, $admins);
    }

    /**
     * Display a listing of the admins.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailedAdmins()
    {
        $admins = $this->users->isAdmin()->latest()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->userTransformer, $admins);
    }

    /**
     * Display a listing of the dispatchers.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailedDispatchers()
    {
        $dispatchers = $this->users->isDispatcher()->latest()->paginate(20);

        return $this->jsonRespond->respondPaginator($this->userTransformer, $dispatchers);
    }

    /**
     * Display a listing of the drivers.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailedDrivers()
    {
        $drivers = $this->users->isDriver()->latest()->paginate(20);

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
     * @param User $users
     * @return \Illuminate\Http\Response
     */
    public function show(User $users)
    {
        return $this->jsonRespond->respondModel($this->userTransformer, $users);
    }

    /**
     * Update the specified user in storage.
     *
     * @param AdminRequest $request
     * @param User $users
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, User $users)
    {
        $users->update($request->all());

        return $this->jsonRespond->respondModel($this->userTransformer, $users);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $users
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(User $users)
    {
        $users->delete();

        return $this->jsonRespond->respondDelete();
    }
}
