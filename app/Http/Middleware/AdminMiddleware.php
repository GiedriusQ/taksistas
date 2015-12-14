<?php

namespace App\Http\Middleware;

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
        if ($request->user()) {
            if ($request->user()->type == 0) {
                return $next($request);
            }
        }

        return response()->json(['error' => 'Unauthorized.'], 401);
    }
}
