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
//        if(collect(config('app.adminips'))->contains($request->ip()) && !request()->has('yes')) {
//            Logger::msg('not logging ' . $request->url() . ' for ' . $request->ip());
//            session(['log_id' => 0]);
//            return $next($request);
//        }

        $log = \App\Models\LogRecord::create([
            'ip' => $request->ip(),
            'ua' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'http_code' => '<unfinished>',
            'request_start' => \DB::raw('now(6)'),
            'info' => \json_encode(array_merge($_GET, $_POST, $_COOKIE, $_FILES))
        ]);

        $logIds = session('log_ids', []);
        $logIds[] = $log->id;
        session(['log_ids' => $logIds]);

        $isGay = \App\Gay::firstWhere('ip', $request->ip());
        session(['isGay' => true]);

        return $next($request);
    }
}
