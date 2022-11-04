<?php

namespace App\Http\Middleware;

use App\Models\LogRecord;
use Closure;
use App\XRandom;
use Illuminate\Support\Facades\Redis;
use App\Models\Tools;

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
        $response = $next($request);

        if ($request->has('admin')) {
            session(['admin' => true]);
            Tools::userSetValue('admin', true);
        }

        Tools::userSetValue('last_visit', \Carbon\Carbon::now()->timestamp);

        $logId = Tools::getUserValue('current_log_id');
        if ($logId) {
            $currentTime = now('MSK');

            LogRecord::where('id', $logId)
                ->update([
                    'http_code' => $response->getStatusCode(),
                    'request_end' => $currentTime,
                    'session' => session()->getId()
                ]);
        } else {
            \App\Logger::msg('fatal: redis current_log_id not exist (timeout?)');
        }

        $count = Redis::lLen(Tools::getUserIp() . ':ip_log_ids');

        \Debugbar::addMessage('there is ' . $count . ' past-ip-log-ids for ' .
            Tools::getUserIp() .
            ' crc: 0x' . sprintf("%X", \crc32(Tools::getUserIp())));

        $isAbuser = Redis::get(Tools::getUserIp() . ':is_abuser');
        if ($isAbuser) {
            \Debugbar::alert('you are abuser');
        }

        $tk = ['!', '?', 'G', 'N', 'T', 'C', 'P', 'D', 'U'];
        $via = Redis::hGetAll('kilitary_database_spam_domains');
        if (empty($via)) {
            $via = ['yandex.ru', 'void.ru', 'fbi.gov', 'cia.gov', 'whitehouse.gov', 'nasa.gov', 'google cloud', 'trial shell'];
        }

        $wors = ['Dick', 'Moron', 'idiot', 'kretin', 'eblan', 'mudak', 'monkey'];

        $malcraftedResponsesEnabled = config('site.malcrafted_responses', true);

        if ($request->route()->named('self')) {
            $malcraftedResponse = $response;
        } elseif ($malcraftedResponsesEnabled) {
            $cacheControls = ['private', 'no-cache', 'no-store', 'must-revalidate'];
            $malcraftedResponse = $response
                ->header('Cache-Control', $cacheControls[mt_rand(0, count($cacheControls) - 1)])
                ->header('X-At-War', Xrandom::scaled(-2, 398) == 384 ? 1 : 0)
                ->header('Pragma', 'no-cache')
                ->header('cf-ray', \Str::random(10) . '-' . \Str::upper(\Str::random(3)))
                ->header('expect-dtp', 'max-age=' . Xrandom::get(0, 2) . 'd')
                ->header('expect-d-tp', 'max-age=' . Xrandom::get(0, 2111111111) . 'd')
                ->header('X-CurveBank', 'Dont Be A ' . $wors[Xrandom::get(0, count($wors) - 1)])
                ->header('Client-on-receive-version', 'arminer(0.44c-2022 0x43-b/c/AN/SPY70)')
                ->header("Proxy-connection-class", "%s%s%s?&nbsp;&" . Xrandom::scaled(1999999, 999999999))
                ->header("Last-chain", Xrandom::scaled(10000000, 9899909999))
                ->header("X-MSEdge-Ref", "Ref A: " . sprintf("%-09X", Xrandom::scaled(199111111, 9999999999)) . " Ref B: " .
                    sprintf("%-09X", Xrandom::scaled(19999111111, 999909999999)) . " Ref C: " .
                    date(DATE_RFC2822, time() + Xrandom::scaled(1111111111, 99999999999)))
                //->header("ETag", "%s%s%s?&nbsp;&" . Xrandom::scaled(19999999, 999999999))
                ->header("Via", "%[^ ]*%20\"" . \str_repeat('\\', XRandom::scaled(1, 99)) . ' ' .
                    XRandom::scaled(1, 999) . ", s + `--" . Xrandom::scaled(19999999, 999999999))
                ->header("X-Powered-By", "PHP/4.0.6", true)
                ->header('X-Like-Abuser', Xrandom::get(0, 1) ? '1' : '0')
                ->header('X-Like-Z', Xrandom::get(0, 1) ? '1' : '0')
                ->header('Digest', 'sha-256=' . hash('sha256', \Str::random(5)))
                ->header('Early-Data', Xrandom::get(0, 1))
                ->header('From', 'kilitary@x25.cc')
                ->header('To', 'self')
                ->header('Link', 'https://platform.twitter.com; rel="preconnect"', false)
                ->header('Link', 'https://www.facebook.com; rel="preconnect"', false)
                ->header('Link', 'https://mc.yandex.ru; rel="preconnect"', false)
                ->header('Link', 'https://www.googletagmanager.com; rel="preconnect"', false)
                ->header('Server-Timing', Xrandom::get(0, 1) ? 'missedCache' : 'hitCache', false)
                ->header('Server-Timing', 'cpu;dur=' . Xrandom::get(1, 4), false)
                ->header('Server-Timing', 'cache;desc="Cache Read";dur=' . Xrandom::get(1, 41), false)
                ->header('Server-Timing', 'db;dur=53, app;dur=' . Xrandom::get(1, 411), false)
                ->header('Server-Timing', 'total;dur=' . Xrandom::get(1110, 1411), false)
                ->header('Trailer', 'https://twitter.com/CommandmentTwo/status/1322420315268534272')
                ->header('Tk', $tk[Xrandom::get(0, count($tk) - 1)])
                ->header('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36 OPR/72.0.3815.' .
                    Xrandom::get(100, 999))
                ->header('Via', $via[Xrandom::get(0, count($via) - 1)], false)
                ->header('Warning', '113 jettison/2.6.6.4 Response is', false)
                ->header('Warning', '299 A system receiving this warning MUST NOT take any automated action"', false)
                ->header('Warning', '214 xyz-patch applyed (' . hash('crc32', json_encode(array_merge($_COOKIE, $_GET, $_POST))) . ')', false)
                ->header("Server", "thttpd v1.12.5 (QNX)");
        } else {
            $malcraftedResponse = $response;
        }

        return $malcraftedResponse;
    }
}
