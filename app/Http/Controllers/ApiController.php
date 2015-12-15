<?php

namespace App\Http\Controllers;

use App\GK\Json\JsonRespond;
use App\GK\Transformers\UserTransformer;

class ApiController extends Controller
{
    /**
     * @var JsonRespond
     */
    protected $jsonRespond;

    public function __construct(JsonRespond $jsonRespond)
    {
        $this->jsonRespond = $jsonRespond;
    }

    protected function respondUserPaginator(UserTransformer $userTransformer, $users)
    {
        $data = $userTransformer->transformPaginator($users);

        return $this->jsonRespond->respondWithPagination($users, $data);
    }

    protected function respondUserModel(UserTransformer $userTransformer, $user)
    {
        $data = $userTransformer->transformModel($user);

        return $this->jsonRespond->setStatusCode(201)->respondStore($data);
    }
}