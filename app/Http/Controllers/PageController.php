<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Amnuts\Opcache\Service;
use App\Comment;
use App\Logger;
use App\Models\Page;
use App\Models\Tools;
use App\Services\NewsService;
use App\XRandom;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Intervention\Image\ImageManager;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use Str;
use WebArticleExtractor;
use const JSON_PRETTY_PRINT;
use const PREG_SET_ORDER;

class PageController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function rate(Request $request, $id)
    {

        if (XRandom::scaled(1, 3) >= 2 && XRandom::maybe()) {
            return redirect()->back()->with('message', 'your rate was rejected by remote system');
        }

        $keys = ['prog_ok', 'prog_bad'];
        $key = $keys[XRandom::scaled(0, 1)];

//        $op = ["+", "-"];
//        $op = $op[XRandom::scaled(0, 1)];
        $op = "+";

        \DB::update("update news set {$key} = {$key} {$op} 1 where id = ?", [$id]);

        Logger::msg('rate ' . $id . ' key ' . $key);

        return redirect()->back()->with('message', 'rate applyed');
    }

    public function addComment(Request $request)
    {
        return view('comments.new');
    }

    public function opcache(Request $request)
    {
        return response(require_once '../vendor/amnuts/opcache-gui/index.php');
    }

    public function cartSubmit(Request $request)
    {
        $cart = collect(Tools::getCart());

        if (!$cart) {
            return redirect('/')->with('message', 'empty cart');
        }

        $total = 0.0;
        $cart->transform(static function ($item, $key) use (&$total) {
            $record['cost'] = Tools::getItemCost($item);
            $total += $record['cost'];
            $record['name'] = $item;
            return $record;
        });

        $cart = $cart->toArray();

        return view('cart.submit', compact('cart', 'total'));
    }

    public function cartFinalSubmit(Request $request)
    {
        $cart = Tools::getCart();

        if (!$cart) {
            return redirect('/')->with('message', 'empty cart');
        }

        $ai = Tools::arbitraryInfo([
            'tags' => 'cart',
            'json' => \json_encode($cart),
            'priority' => 'high'
        ]);

        $id = 0;

        $crc32b = -1;
        if ($ai) {
            $crc32b = hash('crc32b', $ai->json);
            $id = $ai->id;
            $ai->text = 'crc32b:' . $crc32b;
            $ai->save();
        } else {
            $id = -1;
        }

        Tools::clearCart();

        return view('cart.final_submit', compact('id', 'crc32b'));
    }

    public function relink(Request $request)
    {
        session()->flush();

        return redirect(route('home'));
    }

    public function index(Request $request)
    {
        Logger::msg('index> remote: ' . $request->ip() . ':' . $_SERVER['REMOTE_PORT'] . ' uri: ' . $request->fullUrl() . ' from: ' . $request->header('referer') .
            " session: " . session()->getId() . ' visits: ' . ((int) \Tools::ipVisits()));

        $interesting = Page::interesting(5) ?? [];

        $news = $this->newsService->retrieve(5, true);

        $comments = \App\Comment::getLatest(5) ?? [];

        $videos = \App\Models\Video::getLatest(5) ?? [];

        return view('home', compact('videos', 'comments', 'news'));
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

            for ($i = 0; $i < $maxI; $i++) {

                XRandom::followRand(XRandom::get(1, 11));

                $overlappedImage = $manager->make('../resources/media/darkcp.jpg')
                    ->resize(\App\XRandom::scaled(1, 200), \App\XRandom::scaled(1, 200));

                if (XRandom::maybe()) {
                    $overlappedImage->rotate(XRandom::scaled(-360, 360));
                }

                if (XRandom::maybe()) {
                    $overlappedImage->contrast(XRandom::scaled(-10, 100));
                }

                if (XRandom::maybe()) {
                    $overlappedImage->pixelate(XRandom::scaled(1, $overlappedImage->width() + $overlappedImage->height()));
                }

                if (XRandom::maybe()) {
                    $gamma = 0.1 + XRandom::scaled(1.1, 2.9);
                    if ($gamma <= 0) {
                        Logger::msg('gamma ' . $gamma);
                    }
                    $overlappedImage->gamma($gamma);
                }

                if (XRandom::maybe()) {
                    $overlappedImage->blur(XRandom::scaled(1, 120));
                }

                $coords = ['top - left', 'center', 'top - right', 'bottom - left', 'bottom - right'];

                $srcImage->insert($overlappedImage, $coords[XRandom::scaled(0, count($coords) - 1)],
                    XRandom::scaled(1, 122), XRandom::scaled(1, 122))->sharpen(XRandom::scaled(1, 100));
            }

            $srcImage->resize($request->get('widthmax'), $request->get('heightmax'));
        } catch (Exception $e) {
            Logger::msg('exception: ' . $e->getMessage());
        }

        return XRandom::maybe() ?
            \response()->file('media/sh.png', ['Content-Type' => 'image/png'])
            :
            (XRandom::maybe() ? \response('', 410) : $srcImage->response('image/png'));
    }

    public function cp(Request $request)
    {
        $abusers = \App\Abuser::all() ?? collect([]);

        return view('cparea', compact('abusers'));
    }

    public function deleteComment(Request $request, $commentId)
    {
        \App\Logger::msg('user ' . $request->ip() . ' deleting comment ' . $commentId);

        $comment = \App\Comment::find($commentId);

        if ($comment && ($comment->ip == $request->ip() || Tools::isAdmin())) {
            \App\Logger::msg('comment to delete: ' . \json_encode($comment, JSON_PRETTY_PRINT));
            $comment->delete();
        }

        return back();
    }

    public function addToCart(Request $request, $code)
    {
        \App\Logger::msg('adding to cart: ' . $code);
        \Tools::addToCart($code);

        return back()->with('message', 'item ' . $code . ' added to cart');
    }

    public function donate(Request $request)
    {
        return view('donate');
    }

    public function writeComment(Request $request)
    {
        $matches = [];
        $linksCount = preg_match_all("#(http(?:s|)://[^\s]*?)#Uusmi", $request->post('comment'), $matches,
            PREG_SET_ORDER);

        Logger::msg('write comment ', $request->all());

        if (!Tools::isAdmin()
            && !\in_array($request->ip(), config('site.adminips'))
            && Tools::userHasSetting('is_abuser') && Tools::getUserValue('is_abuser') == 1) {
            $existentAbuser = \App\Abuser::where('ip', $request->ip())
                ->first();

            $randomCode = \App\Models\Page::select('code')
                ->inRandomOrder()
                ->limit(1)
                ->value('code');

            Logger::msg('known abuser from "' .
                \Tools::getCountry($request->ip()) . '" [' . $request->ip() . '], tryed to inject his shit: ' .
                ($existentAbuser ? $existentAbuser->firewall_in : -1) . ' times, redirect to ' . $randomCode);

            if ($existentAbuser) {
                $existentAbuser->firewall_in += 1;
                $existentAbuser->save();
            }

            Tools::userSetValue('spam_shit', $request->post('comment'), 3600);

            return redirect('/view/' . $randomCode);
        }

        if (!Tools::isAdmin() && $linksCount >= 1) {
            $randomCode = \App\Models\Page::select('code')
                ->inRandomOrder()
                ->limit(1)
                ->value('code');

            Logger::msg('link abuser from "' .
                \Tools::getCountry($request->ip()) . '" [' . $request->ip() . '], tryed to inject his shit with ' . $linksCount . ' links, ' .
                ' redirect to ' . $randomCode, $matches);

            Tools::userSetValue('spam_shit', $request->post('comment'), 3600);

            return redirect('/view/' . $randomCode);
        }

        $lastVisitSeconds = Tools::getUserValue('last_visit');
        $diff = \Carbon\Carbon::now()->timestamp - (int) $lastVisitSeconds;

        if (!\in_array($request->ip(), config('site.adminips'))
            && $diff <= config('site.min_get_post_diff_secs')) {
            Logger::msg('this is abuser, diff request ' . $diff . ' secs [m ' .
                Tools::getUserValue('last_method') . ', lv ' . $lastVisitSeconds .
                ', now ' . \Carbon\Carbon::now()->timestamp . ']');

            $reason = 'too fast post <difsecs: ' . $diff . '>';

            $abuserGroup = \Str::upper(\Str::random(3));
            $deabuserTime = \Carbon\Carbon::now()->addHours(4)->toDateTimeString();

            $abuser = \App\Abuser::firstOrCreate([
                'ip' => $request->ip()
            ], [
                'nick' => $abuserGroup,
                'ua' => $request->header('User-Agent'),
                'reason' => $reason,
                'deabusertime' => $deabuserTime,
                'firewall_in' => 0
            ]);

            Logger::msg('new abuser ' . $request->ip() . ' appeared, designated ' . $abuserGroup .
                ', deAbuserTime: ' . $deabuserTime . " [reason: " . $reason . ' id: ' . $abuser->id . ']');

            Redis::sadd('abusers', $request->ip());
            Tools::userSetValue('is_abuser', 1);
            Redis::rPush('spammed_text', \stripslashes($request->post('comment')));
            Tools::userSetValue('spam_shit', $request->post('comment'), 3600);

            preg_match_all("#([a-z0-9\-]{2,}?\.[a-zA-Z0-9]{2,}?)#uUsmi", $request->post('comment'), $mm,
                PREG_SET_ORDER);
            foreach ($mm as $m) {
                \App\Logger::msg('add spammed domain ' . $m[1]);
                Redis::hIncrBy('spam_domains', $m[1], 1);
            }

            \App\Audio::abuserDetected();

            $randomCode = \App\Models\Page::select('code')
                ->inRandomOrder()
                ->limit(1)
                ->value('code');

            return redirect('/view/' . $randomCode);
        }

        preg_match_all('#(\w{1,20}\.\w{1,5})#sUumi', $request->post('comment'), $mm, PREG_SET_ORDER);
        $domainLen = 0;
        foreach ($mm as $index => $domain) {
            $domainLen += \Str::length($domain[0]);
        }

        $difflLen = \Str::length($request->post('comment')) - $domainLen;

        Logger::msg('comment spam analyze: domainLen: ' . $domainLen . ' diffLen: ' . $difflLen);
        if ($domainLen > 64 && $difflLen >= 128
            && !\in_array($request->ip(), config('site.adminips'))) {
            $reason = 'links per plain text weight overflow <url: ' . $domainLen . ' > diff: ' . $difflLen . '>';

            $abuserGroup = \Str::upper(\Str::random(3));
            $deabuserTime = \Carbon\Carbon::now()->addHours(4)->toDateTimeString();

            $spamDbCount = Redis::lLen('spammed_text');

            $abuser = \App\Abuser::firstOrCreate([
                'ip' => $request->ip()
            ], [
                'nick' => $abuserGroup,
                'ua' => $request->header('User-Agent'),
                'reason' => $reason,
                'deabusertime' => $deabuserTime,
                'firewall_in' => 0
            ]);

            Logger::msg('new abuser ' . $request->ip() . ' appeared, designated ' . $abuserGroup .
                ', deAbuserTime: ' . $deabuserTime . " [reason: " . $reason . ' spam_db: ' . $spamDbCount . ' id: ' . $abuser->id . ']');

            Redis::sadd('abusers', $request->ip());
            Tools::userSetValue('is_abuser', 1);
            Redis::rPush('spammed_text', \stripslashes($request->post('comment')));
            Tools::userSetValue('spam_shit', $request->post('comment'), 3600);

            preg_match_all("#([a-z0-9\-]{2,}?\.[a-z0-9]{2,}?)#Usumi", $request->post('comment'), $mm,
                PREG_SET_ORDER);
            foreach ($mm as $m) {
                \App\Logger::msg('add spammed domain ' . $m[1]);
                Redis::hIncrBy('spam_domains', $m[1], 1);
            }

            \App\Audio::abuserDetected();

            $randomCode = \App\Models\Page::select('code')
                ->inRandomOrder()
                ->limit(1)
                ->value('code');

            return redirect('/view/' . $randomCode);
        }

        $content = $request->post('comment');
        if (!\Tools::isAdmin()) {
            $content = strip_tags($content);
        }

        $userName = \Str::upper(\Str::limit(hash('sha256', $content . $request->ip() . $request->userAgent()), 6));
        $country = Tools::getCountry($request->ip());
        $prefix = $request->post('type');

        $comment = \App\Comment::create([
            'comment' => $content,
            'ip' => $request->ip(),
            'username' => $userName,
            'prefix' => $prefix,
            'email' => 'unknown@unknown.unknown',
            'country' => $country,
            'page_id' => $request->post('page_id'),
            'info' => json_encode(\array_merge($_POST, $_GET, $_COOKIE, $_FILES, $_SERVER),
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES, 5)
        ]);

        Logger::msg('comment ' . $comment->id . ' created OK');

        return redirect('/')->with('message', 'comment added, CRC32: ' . hash('crc32', $content));
    }

    public function edit(Request $request, $code)
    {
        $page = Page::where('code', $code)
            ->first();

        if (!$page) {
            return redirect('/');
        }

        return view('edit', compact('page'));
    }

    public function update(Request $request, $code)
    {
        $page = Page::where('code', $code)
            ->first();

        if ($page->ip != $request->ip() && !\Tools::isAdmin()) {
            return 'access denied for ' . $request->ip();
        }

        $content = $request->post('content');
        $page->content = $content;
        $page->edits++;
        $page->header = $request->post('header');
        $page->cost = $request->post('cost');
        $page->save();

        return redirect('/view/' . $code)->with('message', 'content updated, CRC32: ' . hash('crc32', $content));
    }

    public function self(Request $request)
    {
        $headers = collect($request->headers);
        $filtered = $headers->filter(function ($value, $key) {
            return !strstr($key, "HTTP");
        });

        $content = "--------------------------------------------------\r\n";
        foreach ($filtered->toArray() as $key => $value) {
            $content .= "{$key}:" . json_encode($value) . "\r\n";
        }

        $content .= "key:" . hash('sha256', $request->ip() . "--") . "\r\n";
        $content .= "-------------------------------------------------\r\n";
        $content .= 'crc[' . hash('crc32', $content) . ']';

        return \response($content, \App\XRandom::get(0, 2) == 1 ? 200 : 299);
    }

    public function touch(Request $request, $code)
    {
        $page = \App\Models\Page::where('code', $code)
            ->first();

        $touchTime = \Carbon::now();
        $page->updated_at = $touchTime;
        $page->save();

        \App\Logger::msg($request->ip() . ' touched ' . $page->code . ' @ ' . $touchTime);

        return back()->with('message', 'touch applyed');
    }

    public function reset(Request $request)
    {
        session()->flush();

        return redirect('/?reset = ' . XRandom::get(0, 5));
    }

    public function page(Request $request, $code)
    {
        $currentDeleted = session('currentDeleted');
        if ($currentDeleted && in_array($code, $currentDeleted)) {
            return redirect('/delete/' . $code);
        }

        $page = \App\Models\Page::where('code', $code)
            ->orWhere('header', $code)
            ->first();

        if ($page) {
            $content = $page->content;
            $header = $page->header;
            $views = $page->views;
            $edits = $page->edits;
            $page->views += 1;
            $page->save();

            $content = \preg_replace_callback('#(\w{1,22}\W+?)#u', function ($matches) {
                if (XRandom::get(0, 25) != 3) {
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

            if (Tools::userHasSetting('spam_shit')) {
                $spamShit = Tools::getUserValue('spam_shit');

                $comments[] = [
                    'id' => -1,
                    'comment' => $spamShit,
                    'ip' => $request->ip(),
                    'info' => null,
                    'country' => null,
                    'username' => \Str::random(5),
                    'email' => 'anon@non.ru',
                    'page_id' => $page_id,
                    'created_at' => \Carbon::now()
                ];

                Logger::msg(Tools::getUserIp() . ' is abuser, looking at page ' . $code . ', added his ' . strlen($spamShit) . ' bytes shit');
            }

            $environment = Environment::createCommonMarkEnvironment();
            $environment->addExtension(new AutolinkExtension());
            $environment->addExtension(new DisallowedRawHtmlExtension());
            $environment->addExtension(new SmartPunctExtension());
            $environment->addExtension(new StrikethroughExtension());
            //$environment->addExtension(new TableExtension());
            $environment->addExtension(new TaskListExtension());
            // $environment->addExtension(new SmartPunctExtension());
            $config = [
                'smartpunct' => [
                    //'double_quote_opener' => '`',
                    //'double_quote_closer' => '\'',
                    'single_quote_opener' => '‘',
                    'single_quote_closer' => '’',
                ],
            ];

            $converter = new CommonMarkConverter($config, $environment);
            $content = $converter->convertToHtml($content);
            $country = \Tools::getCountry($page->ip);
        } else {
            $content = "[no such content]";
            $header = "[no such header] (" . $code . ")";
            $views = -2;
            $edits = -4;

            return back()
                ->with('message', $content);
        }

        $keys = Tools::getArrayKeys(11);
        if ($keys->count() >= 2) {
            $keys->put(\App\XRandom::scaled(0, $keys->count() - 1), '!');
        }
        $keys = $keys->implode(' ');

        $ip = $page->ip;

        $precomment = $request->has('precomment') ? $request->input('precomment') : null;

        return view('page', compact('code', 'content', 'header', 'views', 'edits',
            'description', 'page_id', 'comments', 'country', 'converter', 'keys', 'ip', 'page',
            'precomment'));
    }

    public function delete(Request $request, $code, $mode)
    {
        try {
            $currentDeleted = session('currentDeleted', []);
            $result = null;
            $currentDeleted[] = $code;
            session(['currentDeleted' => $currentDeleted]);
            session(['delMode' => $mode]);

            $page = Page::firstWhere('code', $code);
            if ($page && ($page->ip == $request->ip() || \Tools::isAdmin()) && !$page->blocked) {
                $page->delete();
                $result = true;
            } else {
                \App\Logger::msg('deleting page [access denied]');
                $result = false;
            }
        } catch (Exception $e) {
            \App\Logger::msg('delete()#exception: ' . $e->getMessage() . "\r\n" . $e->getTraceAsString());
            $result = false;
        }

        \App\Logger::msg('user ' . \Tools::getUserIp() . ' command: delete pageCode: ' .
            $code . ' mode: ' . $mode . ' result: ' . (int) $result);
        return view('delete', compact('code'));
    }

    public function abusers(Request $request)
    {
        $abusers = Cache::remember('abusers', 60, function () {
            return \App\Abuser::all();
        });

        return view('abusers', compact('abusers'));
    }

    public function destroy(Request $request)
    {
        Redis::setEx($request->ip() . ':destroy', 240, true);

        \App\Logger::msg('user ' . $request->ip() . ' destroyed site');

        return back();
    }

    public function record(Request $request)
    {
        try {
            if ($request->method() == 'GET') {
                $code = Str::random(15);
                return view('newpage', compact('code'));
            }

            $content = $request->post('content');
            if (empty(trim($content))) {
                $content = "operator was lazy this time";
            }

            $header = $request->post('header');

            if (preg_match("#^take\s?([0-9a-z:/\-\.]*)(?:\s+(\w+)|)$#umUsi", $content, $matches)) {
                \App\Logger::msg('new info: taking article from ' . $matches[1]);
                $uri = $matches[1];

                if (!\Str::contains($uri, 'http')) {
                    $uri = 'http://' . $uri;
                }
                $extractionResult = WebArticleExtractor\Extract::extractFromURL($uri);
                if (isset($matches[2]) && $matches[2] == 'd') {
                    dd($extractionResult);
                }
                $content = \str_replace("\r\n", "<br/><br/>", $extractionResult->text);
                \App\Logger::msg('page len:' . strlen($content));

                if (empty(trim($header))) {
                    $header = Str::substr($extractionResult->title, 0, 10);
                }
            }

            $content = \Tools::isAdmin() ? $content : \strip_tags($content);

            if (strlen($content) <= 5) {
                \App\Logger::msg('content length too small: ' . strlen($content));
                return back();
            }
            if (empty(trim($header))) {
                $header = Str::slug(Str::substr($content, 0, 11), '-');
            }

            $code = Str::slug(Str::substr($content, 0, 20), '-');
            while (Page::firstWhere('code', $code)) {
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
        } catch (Exception $e) {
            \App\Logger::msg('record()#exception: ' . $e->getMessage(), $e->getTraceAsString());
        }

        return redirect('/view/' . $code)->with('message', 'page created, crc32: ' . hash('crc32', $content));
    }
}
