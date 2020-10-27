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
        $log = \App\Models\LogRecord::create([
            'ip' => $request->ip(),
            'ua' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'referer' => $request->headers->get('referer', null),
            'http_code' => '<unfinished>',
            'request_start' => \DB::raw('now(6)'),
            'info' => \json_encode(array_merge($_GET, $_POST, $_COOKIE, $_FILES))
        ]);

        $logIds = session('log_ids', []);
        $logIds[] = $log->id;
        session(['log_ids' => $logIds]);

        $isGay = \App\Gay::where('ip', $request->ip())
            ->exists();
        session(['isGay' => $isGay]);

        return $next($request);
    }
}
