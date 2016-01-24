<?php

namespace App\Http\Requests;

use App\GK\Json\JsonRespond;
use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class RegistrationRequest extends CustomResponse
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'nick' => 'required|unique:sessions'
        ];
    }
}