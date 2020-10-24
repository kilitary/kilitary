<?php

namespace App\Http\Middleware;

use App\Models\LogRecord;
use Closure;

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

        $logId = collect(session('log_ids', []))->pop();
        if($logId) {
            $record = LogRecord::where('id', $logId)
                ->update([
                    'http_code' => $response->getStatusCode(),
                    'request_end' => \DB::raw('now(6)')
                ]);
        }

        return $response
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('X-CurveBank', 'Dont Be A Dick')
            ->header('Client-post-version', 'arminer ' . '(0.1d-2020 0x43-b/c/AN/SPY49)')
            ->header("Proxy-connection-class", "%s%s%s?&nbsp;&" . \App\Xrandom::scaled(1999999, 999999999))
            ->header("Last-chain", \App\Xrandom::scaled(10000000, 9899909999))
            ->header("X-MSEdge-Ref", "Ref A: " . sprintf("%-09X", \App\Xrandom::scaled(199111111, 9999999999)) . " Ref B: " .
                sprintf("%-09X", \App\Xrandom::scaled(19999111111, 999909999999)) . " Ref C: " .
                date(DATE_RFC2822, time() + \App\Xrandom::scaled(1111111111, 99999999999)))
            ->header("ETag", "%s%s%s?&nbsp;&" . \App\Xrandom::scaled(19999999, 999999999))
            ->header("Via", "%[^ ]*%20\,s+`--" . \App\Xrandom::scaled(19999999, 999999999))
            ->header("X-Powered-By", "PHP/4.0.6")
            ->header("Server", "thttpd/0.3b");
    }
}
