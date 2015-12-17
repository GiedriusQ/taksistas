<?php

namespace App\Http\Requests\Driver;

use App\Http\Requests\CustomResponse;

class UpdateOrderRequest extends CustomResponse
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->ownsOrder($this->route('orders'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|in:0,1,2',
            'to'     => 'sometimes|required|min:3|max:150'
        ];
    }
}
