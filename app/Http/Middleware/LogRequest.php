<?php

namespace App\Http\Middleware;

use Closure;

class LogRequest
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
        $log = \App\Models\LogRecord::create([
            'ip' => $request->ip(),
            'ua' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'info' => \json_encode(array_merge($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES))
        ]);

        session(['log_id' => $log->id]);

        return $next($request);
    }
}
