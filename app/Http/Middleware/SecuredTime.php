<?php
declare(strict_types=1);

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
        if (env('TIMESECURED')) {
            return redirect('/');
        }

        return $next($request);
    }
}
