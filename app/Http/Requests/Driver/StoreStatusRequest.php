<?php

namespace App\Http\Requests\Driver;

use App\Http\Requests\CustomResponse;
use Illuminate\Auth\AuthManager;

class StoreStatusRequest extends CustomResponse
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param AuthManager $auth
     * @return bool
     */
    public function authorize(AuthManager $auth)
    {
        return $auth->user()->ownsOrder($this->route('orders'));
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
        ];
    }
}
