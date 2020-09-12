<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Logger;
use \App\XRandom;

class PageController extends Controller
{
    public function index(Request $request)
    {
        XRandom::followRand(7);
        Logger::msg('fallback ' . $_SERVER['REMOTE_ADDR'] . ' ' . $request->fullUrl() . ' from ' . $request->header('HTTP_REFERER'));
        $info = $request->fullUrl();
        $gdiSelected = -3;
        $chanceOf = -3;
        $sign = '';
        $shortUrl = \App\ShortUrl::inRandomOrder()->first();
        $pwnedBy = trim(\App\TextSource::one()) . trim(XRandom::get(1998, 2020));
        $fortune = `/usr/games/fortune`;

        return view('home', compact('info', 'gdiSelected', 'chanceOf', 'sign', 'shortUrl', 'pwnedBy', 'fortune'));
    }

    public function fallback(Request $request)
    {
        XRandom::followRand(7);
        Logger::msg('fallback ' . $_SERVER['REMOTE_ADDR'] . ' ' . $request->fullUrl() . ' from ' . $request->header('HTTP_REFERER'));
        $info = $request->fullUrl();
        $gdiSelected = XRandom::get(0, 1);
        $chanceOf = XRandom::get(0, 9);
        $sign = XRandom::sign(26);
        $shortUrl = \App\ShortUrl::inRandomOrder()->first();
        Logger::msg('gdiSelected:  ' . $gdiSelected . ' chanceOf: ' . $chanceOf . ' sign: ' . $sign);
        $pwnedBy = trim(\App\TextSource::one()) . trim(XRandom::get(1998, 2020));
        $fortune = `/usr/games/fortune`;

        return view('home', compact('info', 'gdiSelected', 'chanceOf', 'sign', 'shortUrl', 'pwnedBy', 'fortune'));

    }

}
