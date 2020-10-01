<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Logger;
use \App\XRandom;
use \App\ShortUrl;
use \App\TextSource;
use \App\Models\Page;

class PageController extends Controller
{
    public function index(Request $request)
    {
        XRandom::followRand(7);
        Logger::msg('main ' . $_SERVER['REMOTE_ADDR'] . ' ' . $request->fullUrl() . ' from ' . $request->header('HTTP_REFERER'));
        $info = $request->fullUrl();
        $gdiSelected = -3;
        $chanceOf = -3;
        $sign = '';
        $shortUrl = ShortUrl::inRandomOrder()->first();
        $pwnedBy = trim(TextSource::one()) . trim(XRandom::get(1998, 2020));
        $fortune = `cat /home/kilitary/kilitary/public/fortune-state`;
        $code = \Str::random(15);

        $pages = Page::query()
            ->limit(5)
            ->latest()
            ->inRandomOrder()
            ->get();

        $interesting = $pages->pluck('code', 'header', 'content')
            ->toArray();

        return view('home', compact('info', 'gdiSelected', 'chanceOf', 'sign', 'shortUrl', 'pwnedBy', 'fortune', 'code', 'interesting'));
    }

    public function fallback(Request $request)
    {
        XRandom::followRand(7);
        Logger::msg('fallback ' . $_SERVER['REMOTE_ADDR'] . ' ' . $request->fullUrl() . ' from ' . $request->header('HTTP_REFERER'));
        $info = $request->fullUrl();
        $gdiSelected = XRandom::get(0, 1);
        $chanceOf = XRandom::get(0, 9);
        $sign = XRandom::sign(26);
        $shortUrl = ShortUrl::inRandomOrder()->first();
        Logger::msg('gdiSelected:  ' . $gdiSelected . ' chanceOf: ' . $chanceOf . ' sign: ' . $sign);
        $pwnedBy = trim(TextSource::one()) . trim(XRandom::get(1998, 2020));
        $fortune = `cat /home/kilitary/kilitary/public/fortune-state`;

        return view('home', compact('info', 'gdiSelected', 'chanceOf', 'sign', 'shortUrl', 'pwnedBy', 'fortune'));

    }

    public function page(Request $request, $code)
    {
        $page = \App\Models\Page::where('code', $code)
            ->orWhere('header', $code)
            ->first();

        if($page) {
            $content = $page->content;
            $header = $page->header;
            $views = $page->views;
            $page->views += (XRandom::get(0, 8) == 3 ? XRandom::get(1, 4) : 0);
            $page->save();
        } else {
            $content = "[no such content]";
            $header = "[no such header] (" . $code . ")";
            $views = -1;
        }

        return view('page', compact('code', 'content', 'header', 'views'));
    }

    public function record(Request $request, $code)
    {
        if($request->method() == 'GET') {
            $code = \Str::random(15);
            return view('newpage', compact('code'));
        }

        $content = $request->input('content');
        $header = $request->input('header');

        if(empty($header)) {
            $header = \Str::random(40);
        }

        $header = \Str::slug($header, '-');

        $pid = \DB::table('pages')
            ->insertGetId([
                'code' => $code,
                'views' => -1,
                'content' => $content,
                'header' => $header,
                'active' => 1
            ]);

        return redirect('/view/' . $code);
    }
}
