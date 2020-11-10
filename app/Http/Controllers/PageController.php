<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Models\Tools;
use Exception;
use Illuminate\Http\Request;
use \App\Logger;
use \App\XRandom;
use \App\ShortUrl;
use \App\TextSource;
use \App\Models\Page;
use Illuminate\Support\Facades\Redis;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use GeoIp2\Database\Reader;
use Predis\Command\ConnectionQuit;
use Str;
use Intervention\Image\ImageManager;
use const JSON_PRETTY_PRINT;
use const PREG_SET_ORDER;
use \WebArticleExtractor;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function relink(Request $request)
    {
        session()->flush();

        return redirect(route('home'));
    }

    public function index(Request $request)
    {
        XRandom::followRand(7);

        Logger::msg('index> remote: ' . $request->ip() . ':' . $_SERVER['REMOTE_PORT'] . ' uri: ' . $request->fullUrl() . ' from: ' . $request->header('referer') .
            " session: " . session()->getId() . ' visits: ' . ((int) \App\Models\Tools::ipVisits()));

        $info = $request->input('fr');
        $gdiSelected = -3;
        $chanceOf = -3;
        $sign = '';
        $shortUrl = ShortUrl::inRandomOrder(XRandom::scaled(0, 999999999))->first();
        $pwnedBy = trim(TextSource::one()) . trim(XRandom::get(1998, 2020));
        $fortune = `cat fortune-state`;

        $code = Str::random(15);

        $deleted = session('currentDeleted', []);

        $pages = Page::select('code', 'header', 'content')
            ->whereNotIn('code', $deleted)
            ->limit(25)
            ->latest()
            ->get();

        $interesting = $pages
            ->toArray();

        $gaysCount = \App\Gay::query()
            ->count();

        return view('home', compact('info', 'gdiSelected', 'chanceOf', 'sign', 'shortUrl',
            'pwnedBy', 'fortune', 'code', 'interesting', 'gaysCount'));
    }

    public function deleteByIp(Request $request, $ip)
    {
        Comment::where('ip', $ip)
            ->delete();

        return back(Tools::isAdmin() ? 200 : 423);
    }

    public function cpareaImage(Request $request)
    {
        $manager = new ImageManager(['driver' => 'gd']);

        XRandom::followRand(XRandom::scaled(1, 15));

        try {
            $srcImage = $manager->make('../resources/media/darkcp.jpg');

            $maxI = XRandom::scaled(1, 8);

            for($i = 0; $i < $maxI; $i++) {

                XRandom::followRand(XRandom::get(1, 11));

                $overlappedImage = $manager->make('../resources/media/darkcp.jpg')
                    ->resize(\App\XRandom::scaled(1, 200), \App\XRandom::scaled(1, 200));

                if(XRandom::maybe()) {
                    $overlappedImage->rotate(XRandom::scaled(-360, 360));
                }

                if(XRandom::maybe()) {
                    $overlappedImage->contrast(XRandom::scaled(-10, 100));
                }

                if(XRandom::maybe()) {
                    $overlappedImage->pixelate(XRandom::scaled(1, $overlappedImage->width() + $overlappedImage->height()));
                }

                if(XRandom::maybe()) {
                    $gamma = 0.1 + XRandom::scaled(1.1, 2.9);
                    if($gamma <= 0) {
                        Logger::msg('gamma ' . $gamma);
                    }
                    $overlappedImage->gamma($gamma);
                }

                if(XRandom::maybe()) {
                    $overlappedImage->blur(XRandom::scaled(1, 120));
                }

                $coords = ['top - left', 'center', 'top - right', 'bottom - left', 'bottom - right'];

                $srcImage->insert($overlappedImage, $coords[XRandom::scaled(0, count($coords) - 1)],
                    XRandom::scaled(1, 122), XRandom::scaled(1, 122))->sharpen(XRandom::scaled(1, 100));
            }

            $srcImage->resize($request->get('widthmax'), $request->get('heightmax'));
        } catch(Exception $e) {
            Logger::msg('exception: ' . $e->getMessage());
        }

        return XRandom::maybe() ?
            \response()->file('media/sh.png', ['Content-Type' => 'image/png'])
            :
            (XRandom::maybe() ? \response('', 410) : $srcImage->response('image/png'));
    }

    public function cp(Request $request)
    {
        $gays = \App\Gay::all() ?? collect([]);

        return view('cparea', compact('gays'));
    }

    public function deleteComment(Request $request, $commentId)
    {
        \App\Logger::msg('user ' . $request->ip() . ' deleting comment ' . $commentId);

        $comment = \App\Comment::find($commentId);

        if($comment && ($comment->ip == $request->ip() || Tools::IsAdmin())) {
            \App\Logger::msg('comment to delete: ' . \json_encode($comment, JSON_PRETTY_PRINT));
            $comment->delete();
        }

        return back();
    }

    public function addToCart(Request $request, $code)
    {
        \App\Logger::msg('adding to cart: ' . $code);
        \App\Models\Tools::addToCart($code);

        return back();
    }

    public function donate(Request $request)
    {
        return view('donate');
    }

    public function writeComment(Request $request)
    {
        return \Debugbar::measure('adding comment for ' . $request->ip(), function() use ($request) {
            Logger::msg('write comment: ', $request->all());
            $isGay = Redis::get(\App\Models\Tools::getUserId() . ':is_gay');
            if($isGay) {
                $existentGay = \App\Gay::where('ip', $request->ip())
                    ->first();

                $randomCode = \App\Models\Page::select('code')
                    ->inRandomOrder()
                    ->limit(1)
                    ->value('code');

                Logger::msg('known gay from "' .
                    \App\Models\Tools::getCountry($request->ip()) . '" [' . $request->ip() . '], tryed to inject his shit: ' .
                    ($existentGay ? $existentGay->firewall_in : -1) . ' times, redirect to ' . $randomCode);
                if($existentGay) {
                    $existentGay->firewall_in += 1;
                    $existentGay->save();
                }

                return redirect('/view/' . $randomCode);
            }

            preg_match_all('#(\w{1,20}\.\w{1,5})#smi', $request->post('comment'), $mm, PREG_SET_ORDER);
            $domainLen = 0;
            foreach($mm as $index => $domain) {
                $domainLen += \Str::length($domain[0]);
            }

            $difflLen = \Str::length($request->post('comment')) - $domainLen;

            Logger::msg('comment spam analyze: domainLen: ' . $domainLen . ' diffLen: ' . $difflLen);
            if($domainLen > 64 && $difflLen >= 128) {
                $reason = 'links per plain text weight overflow <url: ' . $domainLen . ' > diff: ' . $difflLen . '>';

                $gayGroup = \Str::upper(\Str::random(3));
                $degayTime = \Carbon\Carbon::now()->addHours(4)->toDateTimeString();

                $spamDbCount = Redis::lLen('spammed_text');
                Logger::msg('new gay ' . $request->ip() . ' appeared, designated ' . $gayGroup .
                    ', deGayTime: ' . $degayTime . " [reason: " . $reason . ' spam_db: ' . $spamDbCount . ']');

                \App\Gay::create([
                    'ip' => $request->ip(),
                    'nick' => $gayGroup,
                    'ua' => $request->header('User-Agent'),
                    'reason' => $reason,
                    'degaytime' => $degayTime,
                    'firewall_in' => 0
                ]);

                Redis::sadd('gays', $request->ip());
                Redis::hset($request->ip, 'gay', 1);
                Redis::rPush('spammed_text', \stripslashes($request->post('comment')));

                preg_match_all("#([a-zA-Z0-9\-]{2,}?\.[a-zA-Z0-9]{2,}?)#Usmi", $request->post('comment'), $mm, PREG_SET_ORDER);
                foreach($mm as $m) {
                    \App\Logger::msg('add spammed domain ' . $m[1]);
                    Redis::hIncrBy('spam_domains', $m[1], 1);
                }

                \App\Audio::gayDetected();

                $randomCode = \App\Models\Page::select('code')
                    ->inRandomOrder()
                    ->limit(1)
                    ->value('code');

                return redirect('/view/' . $randomCode);
            }

            $userName = \Str::upper(\Str::random(5));
            $country = Tools::getCountry($request->ip());
            $comment = \App\Comment::create([
                'comment' => $request->post('comment'),
                'ip' => $request->ip(),
                'username' => $userName,
                'email' => 'unknown@unknown.ru',
                'country' => $country,
                'page_id' => $request->post('page_id'),
                'info' => json_encode(\array_merge($_POST, $_GET, $_COOKIE, $_FILES, $_SERVER))
            ]);

            Logger::msg('comment ' . $comment->id . ' created OK');

            return back();
        });
    }

    public function edit(Request $request, $code)
    {
        $page = Page::where('code', $code)
            ->first();

        if(!$page) {
            return redirect('/');
        }

        return view('edit', compact('page'));
    }

    public function update(Request $request, $code)
    {
        $page = Page::firstWhere('code', $code);

        if($page->ip != $request->ip() && !\App\Models\Tools::IsAdmin()) {
            return 'access denied for ' . $request->ip();
        }

        $page->content = $request->post('content');
        $page->edits++;
        $page->header = $request->post('header');
        $page->cost = $request->post('cost');
        $page->save();

        return redirect('/view/' . $code);
    }

    public function touch(Request $request, $code)
    {
        $page = \App\Models\Page::where('code', $code)
            ->first();

        $page->updated_at = \Carbon::now();
        $page->save();

        return back();
    }

    public function reset(Request $request)
    {
        session()->flush();

        return redirect('/?reset = ' . XRandom::get(0, 5));
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
            $page->views += 1;
            $page->save();

            $content = \preg_replace_callback('#(\w{1,22}\W+?)#u', function($matches) {
                if(XRandom::get(0, 25) != 3) {
                    return $matches[0];
                }

                Tools::pushKey($matches[1]);

                return $matches[1];
            }, $content);

            $description = preg_replace_array('/(\s{2,}?)/', [' '], $page->content);
            $description = Str::words($description, 22);

            $page_id = $page->id;

            $comments = $page->load('comments')
                ->comments->toArray();

            $environment = Environment::createCommonMarkEnvironment();
            $environment->addExtension(new AutolinkExtension());
            $environment->addExtension(new DisallowedRawHtmlExtension());
            $environment->addExtension(new SmartPunctExtension());
            $environment->addExtension(new StrikethroughExtension());
            //$environment->addExtension(new TableExtension());
            $environment->addExtension(new TaskListExtension());
            //$environment->addExtension(new SmartPunctExtension());
            $config = [
                'smartpunct' => [
                    'double_quote_opener' => '“',
                    'double_quote_closer' => '”',
                    'single_quote_opener' => '‘',
                    'single_quote_closer' => '’',
                ],
            ];

            $converter = new CommonMarkConverter($config, $environment);
            $content = $converter->convertToHtml($content);
            $country = \App\Models\Tools::getCountry($page->ip);
        } else {
            $content = "[no such content]";
            $header = "[no such header] (" . $code . ")";
            $views = -1;
            $edits = -1;

            return back();
        }

        $keys = Tools::getArrayKeys();
        $keys = collect($keys);
        if($keys->count() > 2) {
            $keys->put(\App\XRandom::scaled(0, $keys->count() - 1), '!');
        }
        $keys = $keys->implode(' ');

        $ip = $page->ip;

        return view('page', compact('code', 'content', 'header', 'views', 'edits',
            'description', 'page_id', 'comments', 'country', 'converter', 'keys', 'ip', 'page'));
    }

    public function delete(Request $request, $code, $mode)
    {
        try {
            $currentDeleted = session('currentDeleted', []);

            $currentDeleted[] = $code;
            session(['currentDeleted' => $currentDeleted]);
            session(['delMode' => $mode]);

            \App\Logger::msg('deleting page code: ' . $code . ' mode: ' . $mode);

            $page = Page::firstWhere('code', $code);
            if($page && ($page->ip == $request->ip() || \App\Models\Tools::isAdmin()) && !$page->blocked) {
                $page->delete();
            } else {
                \App\Logger::msg('deleting page [access denied]');
                $code = "[access denied]";
            }
        } catch(Exception $e) {
            \App\Logger::msg('delete()#exception: ' . $e->getMessage() . "\r\n" . $e->getTraceAsString());
        }

        return view('delete', compact('code'));
    }

    public function gays(Request $request)
    {
        $gays = Cache::remember('gays', 1440, function() {
            return \App\Gay::all();
        });

        return view('gays', compact('gays'));
    }

    public function record(Request $request, $code)
    {
        try {
            \App\Logger::msg($request->method() . '> new info creation: code: ' . $code . ' len: ' . \mb_strlen($request->post('content')));
            if($request->method() == 'GET') {
                $code = Str::random(15);
                return view('newpage', compact('code'));
            }

            $content = $request->post('content');
            if(empty(trim($content))) {
                $content = "operator was lazy this time";
            }

            $header = $request->post('header');

            if(preg_match("#^take\s?([0-9a-zA-Z:/\-\.]*)(?:\s+(\w+)|)$#Usi", $content, $matches)) {
                \App\Logger::msg('taking article from ' . $matches[1]);
                $uri = $matches[1];

                if(!\Str::contains($uri, 'http')) {
                    $uri = 'http://' . $uri;
                }
                $extractionResult = WebArticleExtractor\Extract::extractFromURL($uri);
                if(isset($matches[2]) && $matches[2] == 'd') {
                    dd($extractionResult);
                }
                $content = \str_replace("\r\n", "<br/><br/>", $extractionResult->text);
                \App\Logger::msg('page len:' . strlen($content));

                if(empty(trim($header))) {
                    $header = Str::substr($extractionResult->title, 0, 10);
                }
            }

            $content = \App\Models\Tools::isAdmin() ? $content : \strip_tags($content);

            if(strlen($content) <= 5) {
                \App\Logger::msg('content length too small: ' . strlen($content));
                return back();
            }
            if(empty(trim($header))) {
                $header = Str::slug(Str::substr($content, 0, 11), '-');
            }

            $code = Str::slug(Str::substr($content, 0, 20), '-');
            while(Page::firstWhere('code', $code)) {
                $code = Str::slug(Str::substr($content, 0, 20), '-') . '-' . \Str::random(3);
            }

            $header = Str::slug($header, '-');

            $country = Tools::getCountry($request->ip());
            $header = Str::substr($header, 0, 255);

            $page = Page::create([
                'code' => $code,
                'ip' => $request->ip(),
                'edits' => 0,
                'views' => -1,
                'content' => $content,
                'header' => $header,
                'active' => 1,
                'blocked' => 0,
                'country' => $country
            ]);

            \App\Logger::msg('new page code: ' . $code . ' len: ' . strlen($content) . ' header: ' . $header . ' country: ' . $country);

            // TODO: save in vault
//            if($request->post('inVault') == 'on') {
//                //Tools::savePage($page);
//            }
        } catch(Exception $e) {
            \App\Logger::msg('record()#exception: ' . $e->getMessage(), $e->getTraceAsString());
        }

        return redirect('/view/' . $code);
    }
}
