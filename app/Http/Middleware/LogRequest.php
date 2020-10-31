<?php

namespace App\Http\Middleware;

use Closure;
use App\Logger;
use Illuminate\Support\Facades\Redis;

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

        Redis::setEx($request->fingerprint() . ':log_id', 55, $log->id);
        Redis::rPush(\App\Models\Tools::getUserId() . ':ip_log_ids', $log->id);
        Redis::rPush(\App\Models\Tools::getUserId() . ':request_logs',
            hash('sha256', $request->ip() . $request->header('remote_port') . $request->method() . $request->fullUrl()) . ':' .
            $request->method() . ':' .
            $request->fullUrl() . ':' .
            $request->session()->getId() . ':' .
            ($_SERVER['HTTP_REFERER'] ?? '<empty ref>') . ':' .
            $_SERVER['REMOTE_PORT'] . ':' .
            \microtime(true));

        $isGay = \App\Gay::where('ip', '=', $request->ip())
            ->count();

        Redis::set(\App\Models\Tools::getUserId() . ':is_gay', $isGay);

        return $next($request);
    }
}
