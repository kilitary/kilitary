<?php

namespace App\Http\Middleware;

use App\IpInfo;
use App\Models\Tools;
use Closure;
use App\Logger;
use Exception;
use Illuminate\Support\Facades\Redis;
use  \App\Models\LogRecord;

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
        try {
            $log = LogRecord::create([
                'ip' => $request->ip(),
                'ua' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'referer' => $request->headers->get('referer', null),
                'http_code' => '<unfinished>',
                'request_start' => \DB::raw('now(6)'),
                'info' => \json_encode(array_merge($_GET, $_POST, $_COOKIE, $_FILES), JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_TAG | JSON_NUMERIC_CHECK)
            ]);

            Tools::userSetConfig('current_log_id', $log->id, 55);
            Redis::rPush(Tools::getUserId() . ':ip_log_ids', $log->id);
            Tools::userSetConfigIfNotExist('first_seen', \Carbon\Carbon::now()->timestamp);
            Tools::userSetConfig('last_method', $request->method());
            Tools::userSetConfig('is_gay', (int) Tools::isGay($request->ip()));

            if(!Tools::userHasConfig('probably_gay')) {
                Tools::userSetConfig('probably_gay', (int) (\App\XRandom::get(0, 40) == 34), 3600);
            }

            Redis::rPush(Tools::getUserId() . ':request_logs',
                hash('crc32', $request->ip() . $request->header('remote_port') . $request->method() . $request->fullUrl()) . ':' .
                $request->method() . ':' .
                $request->session()->getId() . ':' .
                $request->ip() . ':' .
                $request->header('remote_port') . ':' .
                \microtime(true));

            Tools::recordIp($request->ip());
        } catch(Exception $e) {
            \App\Logger::msg('exception in logrequest:' . $e->getLine() . '> ' . $e->getMessage());
        }

        return $next($request);
    }
}
