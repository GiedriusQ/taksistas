<?php

namespace App\Http\Middleware;

use App\Liustr\Json\JsonRespond;
use App\Session;
use Closure;

class ApiKey
{
    protected $jsonRespond;

    /**
     * Create a new middleware instance.
     *
     * @param JsonRespond $jsonRespond
     * @param Session $session
     */
    public function __construct(JsonRespond $jsonRespond, Session $session)
    {
        $this->jsonRespond = $jsonRespond;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::whereKey($request->input('api_key'))->exists()) {
            return $this->jsonRespond->setStatusCode(401)->respondWithError('Invalid credentials');
        }

        return $next($request);
    }
}
