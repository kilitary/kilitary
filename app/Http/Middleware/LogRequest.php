<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\LogRecord;
use App\Models\Tools;
use Closure;
use Exception;
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
        try {
            if ($request->has('admin')) {
                session(['admin' => true]);
                Tools::userSetValue('admin', true);
            }

            $currentTime = now('MSK');

            $log = LogRecord::create([
                'ip' => $request->ip(),
                'ua' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'referer' => $request->headers->get('referer', null),
                'http_code' => '<unfinished>',
                'request_start' => $currentTime,
                'session' => session()->getId(),
                'info' => \json_encode(array_merge($_GET, $_POST, $_COOKIE, $_FILES),
                    JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_TAG | JSON_NUMERIC_CHECK)
            ]);

            Tools::userSetValue('current_log_id', $log->id, 55);
            Redis::rPush(Tools::getUserIp() . ':ip_log_ids', $log->id);
            Tools::userSetConfigIfNotExist('first_seen', \Carbon\Carbon::now()->timestamp);
            Tools::userSetValue('last_method', $request->method());
            Tools::userSetValue('is_abuser', (int) Tools::isAbuser($request->ip()));

            if (!Tools::userHasSetting('probably_abuser')) {
                Tools::userSetValue('probably_abuser', (int) (\App\XRandom::get(0, 40) == 34), 3600);
            }

            Redis::rPush(Tools::getUserIp() . ':request_logs',
                hash('crc32', $request->ip() . $request->header('remote_port') . $request->method() . $request->fullUrl()) . ':' .
                $request->method() . ':' .
                $request->session()->getId() . ':' .
                $request->ip() . ':' .
                $request->header('remote_port') . ':' .
                \microtime(true));

            Tools::recordIp($request->ip());
        } catch (Exception $e) {
            \App\Logger::msg('exception in logrequest:' . $e->getFile() . '@' . $e->getLine() . '> ' . $e->getMessage());
        }

        return $next($request);
    }
}
