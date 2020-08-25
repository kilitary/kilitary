<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Logger;

class PageController extends Controller
{
    public function index(Request $request)
    {
        \Log::debug($_SERVER['REMOTE_ADDR'] . ' ' . $request->url() . ' from ' . $request->header('HTTP_REFERER'));
        Logger::msg('fallback ' . $_SERVER['REMOTE_ADDR'] . ' ' . $request->fullUrl() . ' from ' . $request->header('HTTP_REFERER'));
        $info = $request->fullUrl();

        $gdiSelected = mt_rand(0, 1);
        $chanceOf = mt_rand(0, 4);
        Logger::msg($gdiSelected);
        // one run
        return view('home', compact('info', 'gdiSelected', 'chanceOf'));
    }

    public function fallback(Request $request)
    {
        \Log::debug($_SERVER['REMOTE_ADDR'] . ' ' . $request->url() . ' from ' . $request->header('HTTP_REFERER'));
        Logger::msg('fallback ' . $_SERVER['REMOTE_ADDR'] . ' ' . $request->fullUrl() . ' from ' . $request->header('HTTP_REFERER'));
        $info = $request->fullUrl();
        return view('home', compact('info'));
    }
}
