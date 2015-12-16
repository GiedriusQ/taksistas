<?php

namespace App\Http\Requests\Dispatcher;

use App\Http\Requests\CustomResponse;
use Illuminate\Auth\AuthManager;

class StoreUserRequest extends CustomResponse
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param AuthManager $auth
     * @return bool
     */
    public function authorize(AuthManager $auth)
    {
        return $auth->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|min:3|max:60|unique:users',
            'city'     => 'required|min:3|max:60',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6'
        ];
    }
}
