<?php

namespace App\Http\Middleware;

use Closure;
use App\Logger;

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
        if(collect(config('app.adminips'))->contains($request->ip())) {
            Logger::msg('not logging ' . $request->url() . ' for ' . $request->ip());
            session(['log_id' => 0]);
            return $next($request);
        } else {
            //Logger::msg('logging ' . $request->url() . ' for ' . $request->ip());
        }

        $log = \App\Models\LogRecord::create([
            'ip' => $request->ip(),
            'ua' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'http_code' => '<unfinished>',
            'info' => \json_encode(array_merge($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES))
        ]);

        session(['log_id' => $log->id]);

        return $next($request);
    }
}
