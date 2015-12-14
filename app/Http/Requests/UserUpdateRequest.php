<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Auth\AuthManager;

class UserUpdateRequest extends Request
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
        $this->id = $this->route('user');

        return $auth->user()->owns($this->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|min:3|max:60|unique:users,name,' . $this->id . '',
            'city'     => 'required|min:3|max:60',
            'email'    => 'required|email|max:255|unique:users,email,' . $this->id,
            'password' => 'required|min:6'
        ];
    }
}
