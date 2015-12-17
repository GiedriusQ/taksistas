<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Http\Requests;
use App\GK\Json\JsonRespond;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GK\Transformers\UserTransformer;

class LoginController extends Controller
{

    private $jsonRespond;
    private $transformer;

    /**
     * LoginController constructor.
     * @param JsonRespond $jsonRespond
     * @param UserTransformer $transformer
     */
    public function __construct(
        JsonRespond $jsonRespond,
        UserTransformer $transformer
    ) {
        $this->jsonRespond = $jsonRespond;
        $this->transformer = $transformer;
    }

    public function check(Request $request)
    {
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            return $this->jsonRespond->respondModel($this->transformer, $request->user());
        } else {
            return $this->jsonRespond->setStatusCode(401)->respondWithError('Invalid credentials');
        }
    }
}
