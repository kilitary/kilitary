<?php

namespace App\Http\Middleware;

use App\Models\LogRecord;
use Closure;
use \App\XRandom;
use Illuminate\Support\Facades\Redis;

class PostRequest
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
        if($request->has('admin')) {
            session(['admin' => true]);
        }

        $response = $next($request);

        $logId = Redis::get($request->fingerprint() . ':current_log_id');

        if($logId) {
            $record = LogRecord::where('id', $logId)
                ->update([
                    'http_code' => $response->getStatusCode(),
                    'request_end' => \DB::raw('now(6)')
                ]);
        } else {
            \App\Logger::msg('fatal: redis current_log_id not exist (timeout?)');
        }

        $count = Redis::lLen(\App\Models\Tools::getUserId() . ':ip_log_ids');

        \Debugbar::addMessage('there is ' . $count . ' past-ip-log-ids for ' .
            \App\Models\Tools::getUserId() .
            ' crc: 0x' . sprintf("%X", \crc32(\App\Models\Tools::getUserId())));

        $isGay = Redis::get(\App\Models\Tools::getUserId() . ':is_gay');

        if($isGay) {
            \Debugbar::alert('you are gay');
        }

        $tk = ['!', '?', 'G', 'N', 'T', 'C', 'P', 'D', 'U'];
        $via = Redis::hGetAll('kilitary_database_spam_domains');
        if(empty($via)) {
            $via = ['fsb.ru', 'yandex.ru', 'void.ru', 'fbi.gov', 'cia.gov', 'whitehouse.gov', 'nasa.gov'];
        }

        $wors = ['Dick', 'Moron', 'idiot', 'kretin', 'eblan', 'mudak', 'monkey'];

        return $response
            //->header('Cache-Control', 'private, no-cache, no-store, must-revalidate')
            ->header('X-At-War', Xrandom::scaled(-4, 394) == 384 ? 1 : 0)
            ->header('Pragma', 'no-cache')
            ->header('cf-ray', \Str::random(10) . '-' . \Str::upper(\Str::random(3)))
            ->header('expect-dtp', 'max-age=' . \App\XRandom::get(0, 2) . 'd')
            ->header('X-CurveBank', 'Dont Be A ' . $wors[\App\XRandom::get(0, sizeof($wors) - 1)])
            ->header('Client-post-version', 'arminer ' . '(0.1d-2020 0x43-b/c/AN/SPY49)')
            ->header("Proxy-connection-class", "%s%s%s?&nbsp;&" . Xrandom::scaled(1999999, 999999999))
            ->header("Last-chain", Xrandom::scaled(10000000, 9899909999))
            ->header("X-MSEdge-Ref", "Ref A: " . sprintf("%-09X", Xrandom::scaled(199111111, 9999999999)) . " Ref B: " .
                sprintf("%-09X", Xrandom::scaled(19999111111, 999909999999)) . " Ref C: " .
                date(DATE_RFC2822, time() + Xrandom::scaled(1111111111, 99999999999)))
            //->header("ETag", "%s%s%s?&nbsp;&" . Xrandom::scaled(19999999, 999999999))
            ->header(($request->route()->named('self') ? "X-" : "") . "Via", "%[^ ]*%20\"" . \str_repeat('\\', XRandom::scaled(1, 99)) . "" . XRandom::scaled(1, 999) . ", s + `--" . Xrandom::scaled(19999999, 999999999))
            ->header("X-Powered-By", "PHP/4.0.6", false)
            ->header('X-Like-Gay', (int) \App\XRandom::get(0, 1) ? '1' : '0')
            ->header('X-Like-Z', (int) \App\XRandom::get(0, 1) ? '1' : '0')
            ->header('Digest', 'sha-256=' . hash('sha256', \Str::random(5)))
            ->header('Early-Data', \App\XRandom::get(0, 1))
            ->header('From', 'kilitary@x25.cc')
            ->header('To', 'self')
            ->header('Link', 'https://mc.yandex.ru; rel="preconnect"', false)
            ->header('Link', 'https://www.googletagmanager.com; rel="preconnect"', false)
            ->header('Server-Timing', \App\XRandom::get(0, 1) ? 'missedCache' : 'hitCache', false)
            ->header('Server-Timing', 'cpu;dur=' . \App\XRandom::get(1, 4), false)
            ->header('Server-Timing', 'cache;desc="Cache Read";dur=' . \App\XRandom::get(1, 41), false)
            ->header('Server-Timing', 'db;dur=53, app;dur=' . \App\XRandom::get(1, 411), false)
            ->header('Server-Timing', 'total;dur=' . \App\XRandom::get(1110, 1411), false)
            ->header('Trailer', 'https://twitter.com/CommandmentTwo/status/1322420315268534272')
            ->header('Tk', $tk[\App\XRandom::get(0, sizeof($tk) - 1)])
            ->header('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36 OPR/72.0.3815.' .
                \App\XRandom::get(100, 999))
            ->header('Via', $via[\App\XRandom::get(0, sizeof($via) - 1)], false)
            ->header('Warning', '113 jettison/2.6.6.4 Response is', false)
            ->header('Warning', '299 A system receiving this warning MUST NOT take any automated action"', false)
            ->header('Warning', '214 xyz-patch applyed (' . hash('crc32', json_encode(array_merge($_COOKIE, $_GET, $_POST))) . ')', false)
            ->header("Server", "thttpd (QNX" . ($request->route()->named('self') ? "-info-x25" : "") . ")");
    }
}
