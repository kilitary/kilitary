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
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use GeoIp2\Database\Reader;
use Str;
use Intervention\Image\ImageManager;
use const PREG_SET_ORDER;

class PageController extends Controller
{
    public function relink(Request $request)
    {
        session()->flush();

        return redirect(route('home'));
    }

    public function index(Request $request)
    {
        ini_set('xdebug.auto_trace', true);
        XRandom::followRand(7);

        Logger::msg('main ' . $_SERVER['REMOTE_ADDR'] . ' ' . $request->fullUrl() . ' from ' . $request->header('HTTP_REFERER') .
            "session: " . \session_id());

        $info = $request->input('fr');
        $gdiSelected = -3;
        $chanceOf = -3;
        $sign = '';
        $shortUrl = ShortUrl::inRandomOrder()->first();
        $pwnedBy = trim(TextSource::one()) . trim(XRandom::get(1998, 2020));
        $fortune = `cat /home/kilitary/kilitary/public/fortune-state`;

        $code = Str::random(15);

        $deleted = session('currentDeleted', []);

        $pages = Page::select('code', 'header', 'content')
            ->whereNotIn('code', $deleted)
            ->limit(15)
            ->latest()
            ->get();

        $interesting = $pages
            ->toArray();

        return view('home', compact('info', 'gdiSelected', 'chanceOf', 'sign', 'shortUrl',
            'pwnedBy', 'fortune', 'code', 'interesting'));
    }

    public function deleteByIp(Request $request, $ip)
    {
        Comment::where('ip', $ip)
            ->forceDelete();

        return back();
    }

    public function cpareaImage(Request $request)
    {
        $manager = new ImageManager(['driver' => 'gd']);

        XRandom::followRand(XRandom::scaled(1, 5));

        try {
            $srcImage = $manager->make('../resources/media/darkcp.jpg')->resize(52, 52);
            $srcImage->resizeCanvas(XRandom::scaled(45, 66), XRandom::scaled(46, 66), 'center', true);

            for($i = 0; $i < XRandom::scaled(5, 11); $i++) {
                $image = $manager->make('../resources/media/darkcp.jpg')->resize(XRandom::scaled(25, 45), XRandom::scaled(25, 45));

                if(XRandom::maybe()) {
                    $image->rotate(XRandom::scaled(-360, 360));
                }

                if(XRandom::maybe()) {
                    $image->contrast(XRandom::scaled(-100, 100));
                }

                if(XRandom::maybe()) {
                    $image->pixelate(XRandom::scaled($image->width() / 4, $image->width() / 2));
                }
                if(XRandom::maybe()) {
                    $image->gamma(0.01 * XRandom::scaled(32));
                }

                if(XRandom::maybe()) {
                    $image->blur(XRandom::scaled(0, 120));
                }

                $srcImage->insert($image, 'top-left', XRandom::scaled(1, 45), XRandom::scaled(1, 45));
            }
            $srcImage->rotate(XRandom::scaled(-360, 360));
            $srcImage->save('media/cparea.png', 100, 'png');
        } catch(Exception $e) {
            Logger::msg('exception for images: ', $e);
        }

        $file = XRandom::scaled(1, 3) == 2 ? 'media/sh.png' : 'media/cparea.png';
        if(!is_file($file)) {
            return response(['status' => 'possible damaged'])
                ->header('Content-type', 'application/json');
        }
        return \readfile($file);
    }

    public function cp(Request $request)
    {
        $gays = \App\Gay::all();
        if(!$gays) {
            $gays = collect([]);
        }
        return view('cparea', compact('gays'));
    }

    public function deleteComment(Request $request, $commentId)
    {
        \Log::debug('user ' . $request->ip() . ' deleting comment ' . $commentId);

        $comment = \App\Comment::find($commentId);

        if($comment && $comment->ip == $request->ip() || Tools::IsAdmin()) {
            $comment->delete();
        }

        return back();
    }

    public function writeComment(Request $request)
    {
        \Debugbar::measure('adding comment for ' . $request->ip(), function() use ($request) {
            $existentGay = \App\Gay::where('ip', $request->ip())
                ->first();

            if($existentGay) {
                \App\Audio::gayDetected();
                Logger::msg('known gay detected [' . $request->ip() . '], tryed to inject his shit: ' . $existentGay->firewall_in . ' times');
                $existentGay->firewall_in += 1;
                $existentGay->save();
                return back();
            }

            preg_match_all('#(\w{1,20}\.\w{1,5})#smi', $request->post('comment'), $mm, PREG_SET_ORDER);
            $domainLen = 0;
            foreach($mm as $index => $domain) {
                $domainLen += \Str::length($domain[0]);
            }

            $difflLen = \Str::length($request->post('comment')) - $domainLen;

            if($domainLen > 512 && $difflLen >= 1024) {
                $reason = 'links per plain text weight overflow [ url: ' . $domainLen . '> diff: ' . $difflLen . ']';

                $gayGroup = \Str::random(3);
                $gay = \App\Gay::create([
                    'ip' => $request->ip(),
                    'nick' => $gayGroup,
                    'ua' => $request->header('User-Agent'),
                    'reason' => $reason,
                    'degaytime' => \Carbon\Carbon::now()->addCentury()->addMicrosecond(XRandom::scaled(10000, 99999))->toDateTimeString(),
                    'firewall_in' => 0
                ]);

                Logger::msg('new gay ' . $request->ip() . ', designated ' . $gayGroup .
                    ' appeared. DEgayTime: ' . \Carbon\Carbon::createFromDate($gay->degaytime) . "[source: " . $reason . ']');

                return back();
            }

            $country = Tools::getCountry($request->ip());
            $comment = \App\Comment::create([
                'comment' => $request->post('comment'),
                'ip' => $request->ip(),
                'username' => 'anon',
                'email' => 'anon@anon.ru',
                'country' => $country,
                'page_id' => $request->post('page_id'),
                'info' => json_encode(\array_merge($_POST, $_GET, $_COOKIE, $_FILES, $_SERVER))
            ]);
        });

        return back();
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

        if($page->ip != $request->ip() && !\App\Models\Tools::IsAdmin()) {
            return 'access denied for ' . $request->ip();
        }

        $page->content = $request->post('content');
        $page->edits++;
        $page->header = $request->post('header');
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

            $content = \preg_replace_callback('#(\w{1,22}\W+?)#u', function($matches) {
                if(XRandom::get(0, 25) != 3) {
                    return $matches[0];
                }

                Tools::pushKey($matches[1]);

                return "<span class='ignited'>$matches[1]</span>";
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
            $country = $page->country;
        } else {
            $content = "[no such content]";
            $header = "[no such header] (" . $code . ")";
            $views = -1;
            $edits = -1;

            return back();
        }

        $keys = Tools::getKeys();

        return view('page', compact('code', 'content', 'header', 'views', 'edits',
            'description', 'page_id', 'comments', 'country', 'converter', 'keys'));
    }

    public function delete(Request $request, $code, $mode)
    {
        $currentDeleted = session('currentDeleted', []);

        $currentDeleted[] = $code;
        session(['currentDeleted' => $currentDeleted]);
        session(['delMode' => $mode]);

        if(\App\Models\Tools::IsAdmin()) {
            $page = Page::firstWhere('code', $code);
            if($page && !$page->blocked) {
                $page->delete();
            }
        } else {
            $code = "[access denied]";
        }

        return view('delete', compact('code'));
    }

    public function record(Request $request, $code)
    {
        if($request->method() == 'GET') {
            $code = Str::random(15);
            return view('newpage', compact('code'));
        }

        $content = $request->post('content');
        if(empty(trim($content))) {
            $content = "operator was lazy this time";
        }

        $content = \strip_tags($content);

        $header = $request->post('header');

        if(empty(trim($header))) {
            $header = Str::random(40);
        }

        $code = Str::slug(Str::substr($content, 0, 15), '-');
        $header = Str::slug($header, '-');

        $country = Tools::getCountry($request->ip());

        $page = Page::create([
            'code' => $code,
            'ip' => $request->ip(),
            'edits' => 0,
            'views' => -1,
            'content' => Str::substr($content, 0, 65000),
            'header' => Str::substr($header, 0, 128),
            'active' => 1,
            'blocked' => 0,
            'country' => $country
        ]);

        if($request->post('inVault') == 'on') {
            //Tools::savePage($page);
        }

        return redirect('/?from=' . $page->id);
    }
}
