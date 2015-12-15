<?php

namespace App\Http\Requests;

use App\GK\Json\JsonRespond;

class CustomResponse extends Request
{
    /**
     * @var JsonRespond
     */
    private $jsonRespond;

    public function __construct(JsonRespond $jsonRespond)
    {
        $this->jsonRespond = $jsonRespond;
    }

    public function response(array $errors)
    {
        return $this->jsonRespond->setStatusCode(422)->respondValidatorError($errors);
    }
}