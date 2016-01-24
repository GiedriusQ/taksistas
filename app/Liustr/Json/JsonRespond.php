<?php

namespace App\Liustr\Json;

use App\GK\Transformers\Transformer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class JsonRespond
{
    protected $statusCode = 200;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error'       => ['message' => $message],
            'status'      => 'An error occurred while processing your request.',
            'status_code' => $this->getStatusCode()
        ]);
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithData($data)
    {
        return $this->respond(['data' => $data, 'status' => 'Success', 'status_code' => $this->getStatusCode()]);
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondValidatorError($data)
    {
        return $this->respond([
            'error'       => $data,
            'status'      => 'Validation error',
            'status_code' => $this->getStatusCode()
        ]);
    }
}