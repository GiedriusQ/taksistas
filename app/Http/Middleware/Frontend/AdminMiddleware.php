<?php

namespace App\Http\Middleware\Frontend;

use Closure;

class AdminMiddleware
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
            return redirect()->action('Front\LoginController@getLogin');
        }
        if ($request->session()->get('user')->type != 0) {
            return redirect()->action('Front\LoginController@getLogin');
        }

        return $next($request);
    }
}
