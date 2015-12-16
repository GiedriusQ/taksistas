<?php

namespace App\Http\Middleware\Frontend;

use App\GK\Utilities\API;
use Closure;

class ApiAuthentication
{
    /**
     * @var API
     */
    private $API;

    public function __construct(API $API)
    {
        $this->API = $API;
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
        if (!$request->session()->has('email') || !$request->session()->has('password')) {
            $request->session()->forget('user');

            return redirect()->action('Front\LoginController@getLogin');
        }
        $response = $this->API->checkCrediantials();
        if ($response->status_code != '200') {
            $request->session()->forget('user');
            $request->session()->forget('email');
            $request->session()->forget('password');

            return redirect()->action('Front\LoginController@getLogin')->withErrors([$response->error->message]);
        }
        session([
            'user' => $response->data
        ]);

        return $next($request);
    }
}
