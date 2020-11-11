<?php

namespace App\Http\Middleware;

use App\IpInfo;
use App\Models\Tools;
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

        Redis::setEx($request->fingerprint() . ':current_log_id', 55, $log->id);
        Redis::rPush(\App\Models\Tools::getUserId() . ':ip_log_ids', $log->id);

        Redis::set(\App\Models\Tools::getUserId() . ':is_gay', \App\Models\Tools::isGay($request->ip()));
        Redis::setEx(\App\Models\Tools::getUserId() . ':probably_gay', 240, intval(\App\XRandom::get(0, 4) == 2));

        Redis::rPush(\App\Models\Tools::getUserId() . ':request_logs',
            hash('crc32', $request->ip() . $request->header('remote_port') . $request->method() . $request->fullUrl()) . ':' .
            $request->method() . ':' .
            $request->session()->getId() . ':' .
            $request->ip() . ':' .
            $request->header('remote_port') . ':' .
            \microtime(true));

        \App\Models\Tools::recordIp($request->ip());

        return $next($request);
    }
}
