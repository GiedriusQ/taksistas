<?php

namespace App\Http\Middleware\Frontend;

use Closure;

class DispatcherMiddleware
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
            return redirect()->route('frontend.login.index');
        }
        if ($request->session()->get('user')->type != 1) {
            return redirect()->route('frontend.login.index');
        }

        return $next($request);
    }
}
