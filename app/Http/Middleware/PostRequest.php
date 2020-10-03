<?php

namespace App\Http\Middleware;

use Closure;

class PostRequest
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->has('admin')) {
            session(['admin' => true]);
        }

        \App\Logger::msg('post request of ' . $request->fullUrl());
        return $next($request);
    }
}
