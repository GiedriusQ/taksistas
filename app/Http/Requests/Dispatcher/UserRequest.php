<?php

namespace App\Http\Requests\Dispatcher;

use App\Http\Requests\CustomResponse;

class UserRequest extends CustomResponse
{
    private $id;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->owns($this->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->id = $this->route('drivers') ? $this->route('drivers')->id : null;

        return [
            'name'     => 'required|min:3|max:60|unique:users,name,' . $this->id,
            'city'     => 'required|min:3|max:60',
            'email'    => 'required|email|max:255|unique:users,email,' . $this->id,
            'password' => (strcasecmp($this->method(), 'POST') == 0 ? 'required' : 'sometimes') . '|min:6'
        ];
    }
}
