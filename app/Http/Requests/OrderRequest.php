<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OrderRequest extends CustomResponse
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->is_dispatcher();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client'    => 'required|min:3|max:100',
            'from'      => 'required|min:3|max:150',
            'to'        => 'sometimes|min:3|max:150',
            'driver_id' => 'sometimes|exists:users,id,type,2'
        ];
    }
}
