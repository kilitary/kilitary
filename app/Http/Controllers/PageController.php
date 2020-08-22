<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        \Log::debug($_SERVER['REMOTE_ADDR']);
        $info = $request->fullUrl();
        return view('home', compact('info'));
    }

    public function notfound(Request $request)
    {
        \Log::debug($_SERVER['REMOTE_ADDR'] . ' ' . $request->url());
        $info = $request->fullUrl();
        return view('home', compact('info'));
    }
}
