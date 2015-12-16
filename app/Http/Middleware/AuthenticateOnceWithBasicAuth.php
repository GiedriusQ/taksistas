<?php

namespace App\Http\Middleware;

use App\GK\Json\JsonRespond;
use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;

class AuthenticateOnceWithBasicAuth
{
    protected $auth;
    /**
     * @var JsonRespond
     */
    private $jsonRespond;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard $auth
     * @param JsonRespond $jsonRespond
     */
    public function __construct(Guard $auth, JsonRespond $jsonRespond)
    {
        $this->auth        = $auth;
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
        return $this->auth->onceBasic() ?
            $this->jsonRespond->setStatusCode(401)->respondWithError('Invalid credentials')
            : $next($request);
    }

}