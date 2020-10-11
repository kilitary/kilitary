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

        $record = LogRecord::whereId(session('log_id'))
            ->update([
                'http_code' => $response->getStatusCode()
            ]);

        return $response;
    }
}
