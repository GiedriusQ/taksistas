<?php

namespace App\Exceptions;

use App\GK\Json\JsonRespond;
use Exception;
use Illuminate\Auth\Access\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];
    /**
     * @var
     */
    private $jsonRespond;

    public function __construct(LoggerInterface $log, JsonRespond $jsonRespond)
    {
        parent::__construct($log);
        $this->jsonRespond = $jsonRespond;
    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return $this->jsonRespond->setStatusCode(404)->respondWithError('Resource not found!');
        }
        if ($e instanceof NotFoundHttpException) {
            return $this->jsonRespond->setStatusCode(404)->respondWithError('Requested URL not found!');
        }
        if ($e instanceof MethodNotAllowedException) {
            return $this->jsonRespond->setStatusCode(405)->respondWithError('Method not allowed!');
        }
        if ($e instanceof UnauthorizedException) {
            return $this->jsonRespond->setStatusCode(401)->respondWithError('Unauthorized!');
        }
        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->jsonRespond->setStatusCode(405)->respondWithError('Method not allowed!');
        }
        if ($e instanceof UnprocessableEntityHttpException) {
            return $this->jsonRespond->setStatusCode(422)->respondWithError($e);
        }

        return parent::render($request, $e);
    }
}
