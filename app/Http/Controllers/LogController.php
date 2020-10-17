<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logs = \App\Models\LogRecord::select('id', 'ip', 'http_code', 'method', 'url', 'ua', 'info', 'created_at')
            ->latest()
            ->get();

        return view('logs', compact('logs'));
    }
}
