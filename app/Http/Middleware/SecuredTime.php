<?php

namespace App\Http\Middleware;

use Closure;

class SecuredTime
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
        if(env('TIMESECURED') == true) {
            return redirect('/');
        }

        return $next($request);
    }
}
