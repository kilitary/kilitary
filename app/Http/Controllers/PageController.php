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
        $info = $request->input('fr');
        $gdiSelected = -3;
        $chanceOf = -3;
        $sign = '';
        $shortUrl = ShortUrl::inRandomOrder()->first();
        $pwnedBy = trim(TextSource::one()) . trim(XRandom::get(1998, 2020));
        $fortune = `cat /home/kilitary/kilitary/public/fortune-state`;

        $code = \Str::random(15);

        $deleted = session('currentDeleted', []);
        $pages = Page::select('code', 'header')
            ->whereNotIn('code', $deleted)
            ->limit(15)
            ->inRandomOrder()
            ->get();

        $interesting = $pages->pluck('code', 'header', 'content')
            ->toArray();

        return view('home', compact('info', 'gdiSelected', 'chanceOf', 'sign', 'shortUrl', 'pwnedBy', 'fortune', 'code', 'interesting'));
    }

    public function edit(Request $request, $code)
    {
        $page = Page::where('code', $code)
            ->first();

        return view('edit', compact('page'));
    }

    public function update(Request $request, $code)
    {
        $page = Page::where('code', $code)
            ->first();

        if($page->ip != $request->ip()) {
            return 'access denied for ' . $request->ip();
        }

        $page->content = $request->post('content');
        $page->edits++;
        $page->save();

        return redirect('/view/' . $code);
    }

    public function fallback(Request $request)
    {
        XRandom::followRand(7);
        Logger::msg('fallback ' . $_SERVER['REMOTE_ADDR'] . ' ' . $request->fullUrl() . ' from ' . $request->header('HTTP_REFERER'));
        $info = $request->input('fr');
        $gdiSelected = XRandom::get(0, 1);
        $chanceOf = XRandom::get(0, 9);
        $sign = XRandom::sign(26);
        $shortUrl = ShortUrl::inRandomOrder()->first();
        Logger::msg('gdiSelected:  ' . $gdiSelected . ' chanceOf: ' . $chanceOf . ' sign: ' . $sign);
        $pwnedBy = trim(TextSource::one()) . trim(XRandom::get(1998, 2020));
        $fortune = `cat /home/kilitary/kilitary/public/fortune-state`;

        return view('home', compact('info', 'gdiSelected', 'chanceOf', 'sign', 'shortUrl', 'pwnedBy', 'fortune'));

    }

    public function reset(Request $request)
    {
        session()->flush();

        return redirect('/?reset=' . XRandom::get(0, 5));
    }

    public function page(Request $request, $code)
    {
        $currentDeleted = session('currentDeleted');
        if($currentDeleted && in_array($code, $currentDeleted)) {
            return redirect('/delete/' . $code);
        }

        $page = \App\Models\Page::where('code', $code)
            ->orWhere('header', $code)
            ->first();

        if($page) {
            $content = $page->content;
            $header = $page->header;
            $views = $page->views;
            $edits = $page->edits;
            $page->views += (XRandom::get(0, 3) == 1 ? XRandom::get(1, 4) : 0);
            $page->save();

            $content = \preg_replace_callback("/(\w{1,22}\s+?)/u", function($matches) {
                if(XRandom::get(0, 25) != 3) {
                    return $matches[0];
                }
                $s = " <span class='ignited'>$matches[1]</span> ";
                return $s;
            }, $content);

        } else {
            $content = "[no such content]";
            $header = "[no such header] (" . $code . ")";
            $views = -1;
            $edits = -1;
        }
        return view('page', compact('code', 'content', 'header', 'views', 'edits'));
    }

    public function delete(Request $request, $code, $mode)
    {
        $currentDeleted = session('currentDeleted', []);

        $currentDeleted[] = $code;
        session(['currentDeleted' => $currentDeleted]);
        session(['delMode' => $mode]);

        if($request->ip() == env('ADMIN_IP')) {
            $page = Page::firstWhere('code', $code);
            if($page) {
                $page->delete();
            }
        }

        return view('delete', compact('code'));
    }

    public function record(Request $request, $code)
    {
        if($request->method() == 'GET') {
            $code = \Str::random(15);
            return view('newpage', compact('code'));
        }

        $content = $request->post('content');
        $header = $request->post('header');

        if(empty($header)) {
            $header = \Str::random(40);
        }

        $code = \Str::slug(\Str::substr($content, 0, 15), '-');
        $header = \Str::slug($header, '-');

        $pid = \DB::table('pages')
            ->insertGetId([
                'code' => $code,
                'ip' => $request->ip(),
                'edit' => 0,
                'views' => -1,
                'content' => $content,
                'header' => $header,
                'active' => 1
            ]);

        return redirect('/view/' . $code);
    }
}
