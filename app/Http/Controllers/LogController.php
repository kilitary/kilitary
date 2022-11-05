<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logs = \Debugbar::measure('getting logs', function () use ($request) {
            return \App\Models\LogRecord::select('id', 'ip', 'http_code', 'method', 'url', 'ua', 'info', 'created_at')
                ->where('ip', '!=', $request->ip())
                ->with('ipInfo')
                ->limit(10)
                ->latest()
                ->get();;
        });

        return view('logs', compact('logs'));
    }
}
