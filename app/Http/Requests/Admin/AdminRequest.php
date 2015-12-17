<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\CustomResponse;

class AdminRequest extends CustomResponse
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->is_admin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('users') ? $this->route('users')->id : ($this->route('drivers') ? $this->route('users')->id : null);

        return [
            'name'     => 'required|min:3|max:60|unique:users,name,' . $id,
            'city'     => 'required|min:3|max:60',
            'email'    => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|min:6'
        ];
    }

}
