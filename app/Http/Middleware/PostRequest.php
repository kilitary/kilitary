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

        $logId = session('log_id', 0);
        if($logId) {
            $record = LogRecord::where('id', $logId)
                ->update([
                    'http_code' => $response->getStatusCode(),
                    'request_end' => \DB::raw('now(6)')
                ]);
        }

        return $response;
    }
}
