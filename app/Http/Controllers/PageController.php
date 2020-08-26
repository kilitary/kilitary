<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Logger;
use \App\XRandom;

class PageController extends Controller
{
    public function index(Request $request)
    {
        XRandom::followRand();

        \Log::debug($_SERVER['REMOTE_ADDR'] . ' ' . $request->url() . ' from ' . $request->header('HTTP_REFERER'));
        Logger::msg('fallback ' . $_SERVER['REMOTE_ADDR'] . ' ' . $request->fullUrl() . ' from ' . $request->header('HTTP_REFERER'));
        $info = $request->fullUrl();

        $gdiSelected = XRandom::get(0, 1);
        $chanceOf = XRandom::get(0, 5);
        $sign = XRandom::sign(24);

        Logger::msg('gdiSelected:  ' . $gdiSelected . ' chanceOf: ' . $chanceOf . ' sign: ' . $sign);

        return view('home', compact('info', 'gdiSelected', 'chanceOf', 'sign'));
    }

    public function fallback(Request $request)
    {
        XRandom::followRand();

        \Log::debug($_SERVER['REMOTE_ADDR'] . ' ' . $request->url() . ' from ' . $request->header('HTTP_REFERER'));
        Logger::msg('fallback ' . $_SERVER['REMOTE_ADDR'] . ' ' . $request->fullUrl() . ' from ' . $request->header('HTTP_REFERER'));
        $info = $request->fullUrl();

        return view('home', compact('info'));
    }

}
