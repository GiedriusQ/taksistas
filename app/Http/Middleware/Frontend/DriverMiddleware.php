<?php

namespace App\Http\Middleware\Frontend;

use Closure;

class DriverMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('user')) {
            return redirect()->action('Front\LoginController@getLogin')->withErrors(['You are not authenticated!']);
        }
        if ($request->session()->get('user')->type != 2) {
            return redirect()->action('Front\LoginController@getLogin')->withErrors(['You are driver!']);
        }

        return $next($request);
    }
}
