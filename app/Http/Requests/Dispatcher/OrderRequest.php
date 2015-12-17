<?php

namespace App\Http\Requests\Dispatcher;

use App\Http\Requests\CustomResponse;

class OrderRequest extends CustomResponse
{
    private $id;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->is_dispatcher() && $this->user()->ownsOrder($this->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->id = $this->route('order') ? $this->route('order')->id : null;

        return [
            'client'    => 'required|min:3|max:100',
            'from'      => 'required|min:3|max:150',
            'to'        => 'sometimes|min:3|max:150',
            'driver_id' => 'sometimes|exists:users,id,type,2'
        ];
    }
}
