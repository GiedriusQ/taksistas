<?php

namespace App\Http\Requests;

class AdminRequest extends CustomResponse
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        //Admin is authorized to update/store everything.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|min:3|max:60|unique:users,name,' . $this->user()->id,
            'city'     => 'required|min:3|max:60',
            'email'    => 'required|email|max:255|unique:users,email,' . $this->user()->id,
            'password' => 'sometimes|min:6',
            'type'     => 'required|in:0,1,2'
        ];
    }

}
