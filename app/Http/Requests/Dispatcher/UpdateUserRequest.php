<?php

namespace App\Http\Requests\Dispatcher;

use App\Http\Requests\CustomResponse;
use Illuminate\Auth\AuthManager;

class UpdateUserRequest extends CustomResponse
{
    private $id;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @param AuthManager $auth
     * @return bool
     */
    public function authorize(AuthManager $auth)
    {
        return $auth->user()->owns($this->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->id = $this->route('drivers')->id;

        return [
            'name'     => 'required|min:3|max:60|unique:users,name,' . $this->id . '',
            'city'     => 'required|min:3|max:60',
            'email'    => 'required|email|max:255|unique:users,email,' . $this->id,
            'password' => 'sometimes|min:6'
        ];
    }
}
