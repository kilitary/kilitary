<?php
declare(strict_types=1);

namespace App\Services;

use App\Logger;
use App\Models\News;
use App\Models\Tools;
use App\XRandom;
use Carbon\Carbon;
use GuzzleHttp\Client;

class NewsService
{
    protected $client;
    protected $url = 'https://lenta.ru';
    protected $proxy = 'socks5://87.236.146.144:1080';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->url,
            'timeout' => 111.0,
            'proxy' => $this->proxy
        ]);
    }

    public function reset()
    {
        News::truncate();
    }

    public function fetch(int $limit)
    {
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36 Edg/107.0.1418.24',
//            'Referer' => $this->url,
//            'Accept-Language' => 'en,ru;q=0.9',
//            'Cookie' => '__lhash_=6889a3ab80520327caca50b56b3f42c5; Chpok=true; Max-Age=604800; Path=/ ',
//            'sec-ch-ua' => "\"Chromium\";v = \"106\", \"Microsoft Edge\";v = \"109\", \"Not;A=Brand\";v = \"299\"",
//            'sec-ch-ua-mobile' => '?0',
//            'sec-ch-ua-platform' => "\"Windows\"",
//            'upgrade-insecure-requests' => '1',
//            'accept-encoding' => 'gzip, deflate, br',
//            'sec-fetch-dest' => 'document',
//            'sec-fetch-mode' => 'navigate',
//            'sec-fetch-site' => 'same-origin',
//            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
//            'sec-fetch-user' => '?1',
//            'sec-fetch-user-anal-destroyed' => false
        ];

        try {
            $response = $this->client->request('GET', '/rss/news', [
                'headers' => $headers,
                'version' => 2,
                // 'debug' => true
            ]);
        } catch (Exception $e) {
            Logger::msg($e->getMessage());
        }

        $data = $response->getBody()->getContents();
        Logger::msg($this->url . ' got content ' . strlen($data));

        //$response = \file_get_contents("https://www.vedomosti.ru/rss/news");
        return $data;
    }

    public function checkFetchNews($limit, $force = false)
    {
        if (News::where('created_at', '<', Carbon::now()->subMinutes(30))
                ->count() <= 15 || $force) {

            $totalAdded = 0;
            $data = $this->fetch($limit);
            $xml = simplexml_load_string($data);
            $json = json_decode(json_encode($xml), true);
            $news = $json['channel']['item'];

            foreach ($news as $item) {
                $pubDate = Carbon::parse($item['pubDate']);
                $title = preg_replace("/[^A-Za-zа-яА-Я0-9\s*\!\.\-]/umsiU", "", $item['title'] ?? '');
                $slug = trim(mb_strtolower(Tools::slugString(\mb_substr($title, 0, 128))), "_");

                $id = News::where('slug', $slug)
                    ->value('id') ?? 0;

                if ($id) {
                    Logger::msg("skip exist {$slug} {$id}");
                    continue;
                }

                $description = $item['description'][0] ?? '';
                $category = preg_replace("/[^A-Za-zа-яА-Я0-9\s*\!\.\-]/umsiU", "", $item['category'] ?? '');
                $len = $item['enclosure']['@attributes']['length'] ?? -1;
                $imageUrl = $item['enclosure']['@attributes']['url'] ?? '';
                $url = $item['link'];
                $costHash = md5($title ?? '') . ':' . md5($category ?? '') .
                    ':' . md5($len ?? '') . ':' . md5($url ?? '');

                $content = \json_encode($item, JSON_UNESCAPED_UNICODE);

                $progCode = $this->genProgCode($item);

                $news = News::create([
                    'title' => $title,
                    'content' => "!!" . $content,
                    'slug' => $slug,
                    'url' => $url,
                    'description' => $description,
                    'image_url' => $imageUrl,
                    'views' => 1,
                    'published_at' => $pubDate->toDateTimeString(),
                    'category_name_old' => $category,
                    'category_id' => -1,
                    'cost' => $this->getCost($costHash),
                    'source' => 'vedomosti.ru',
                    'length' => $len,
                    'prog_at' => now(),
                    'prog_code' => $progCode
                ]);

                Logger::msg("news id {$news->id} added ({$len} bytes) {$url} {$slug}");

                $totalAdded++;
            }

            return $totalAdded;
        }
    }

    public function genProgCode($item)
    {
        $serZ = \json_encode($item);

        $x = [1 => 1, 2 => 5, 3 => 4, 4 => 8, 5 => 3, 6 => 8, 7 => 0, 8 => 9, 9 => 10, 0 => 1];
        $y = [0 => 9];
        $c = [];

        $codeAt = '';

        $rndLoop = XRandom::scaled(1, 10);
        while ($rndLoop--) {
            $min = 0;
            $max = XRandom::scaled($x[$rndLoop], strlen($serZ) - 1);

            $codeAt .= ord($serZ[$max]);

            if (XRandom::maybe() && XRandom::scaled(0, 5) == 4) {
                $max = XRandom::scaled(2, min(2, strlen($serZ) - 1));
                $codeAt .= ord($serZ[$max]);
            }

            $codeAt .= ' ';
        }

        return trim($codeAt);
    }

    public function getCost(string $hash): float
    {
        if ((XRandom::maybe() && XRandom::scaled(0, 3) == 3) || XRandom::scaled(1, 9) <= 5) {
            $c = max(0, (\substr_count($hash, '2') + \substr_count($hash, '4')) ^ 9);
            $b = XRandom::scaled(2, max(3, 4 + $c));
            $min = (-1 + $b);
            $cost = Xrandom::get(abs($min), abs($min) + mt_rand(0, 12));
            if ($cost <= -1) {
                Logger::err('alarm min cost -1 ' . "c {$c} b {$b} min {$min} cost {$cost}");
            }
        } else {
            $cost = 0.0;
        }
        Logger::msg("getCost({$hash}) = $cost");
        return (float) $cost;
    }

    public function retrieve($limit = 5, $doFetch = false, $force = false)
    {
        $news = News::limit($limit)
            ->latest()
            ->get();

        if (($news && count($news) <= 0 && $doFetch) || $force) {
            $added = $this->checkFetchNews($limit, $force);
            session()->flash('message', '+' . $added);
            if ($added) {
                $news = News::limit($limit)
                    ->get();
            }
        }

        $y = [1 => '!', 2 => '@', 3 => '#', 4 => '$', 5 => '%',
            6 => '^', 7 => '&', 8 => '*', 9 => '(', 0 => '+'
        ];

        $z = [10 => '9+', 11 => '!!', 12 => '@11', 13 => '13', 14 => '13+',
            15 => '%', 16 => '^&', 17 => '17', 18 => '18', 19 => '19'];

        foreach ($news as &$n) {
            $ok = $n->prog_ok > 99 ? dechex($n->prog_ok) : $n->prog_ok;
            $ok = $n->prog_bad > 99 ? dechex($n->prog_bad) : $n->prog_bad;
            $n->prog_color = '#' . dechex($ok) . '9' . dechex($n->prog_bad) . '991';

            $n->prog_codes = explode(" ", $n->prog_code);

            $newCodes = [];
            foreach ($n->prog_codes as $progCode) {
                if (empty($progCode)) {
                    continue;
                }

                $n->prog_last_d = -1;

                $progCodeLen = strlen($progCode);

                if ($progCodeLen == 2) {
                    $charCode = $progCode[0];
                    $digit = $y[$charCode];
                    $charCode = $progCode[1];
                    $digit .= $y[$charCode];

                    if ((int) $digit !== (int) $n->prog_last) {
                        $n->prog_last_d .= $digit . ' ';
                        $n->prog_last = $digit;
                        $newCodes[] = (int) $digit;
                    }
                } else {
                    $digit = '';
                    for ($i = 0; $i < $progCodeLen; $i++) {
                        $charCode = $progCode[$i];
                        if ($i < $progCodeLen - 1) {
                            $charCode .= $progCode[$i + 1];
                        }
                        $digit .= ($z[$charCode] ?? '?');

                        $i++;
                    }
                    if ((int) $digit !== (int) $n->prog_last) {
                        $n->prog_last_d .= $digit . ' ';
                        $n->prog_last = $digit;
                        $newCodes[] = $digit;
                    }
                }
            }

            $nc = \json_encode($newCodes);
            $pc = \json_encode($n->prog_code);
            Logger::msg("prog_code: {$pc}  newCode: {$nc}");
            // $n->prog_codes = $newCodes;

        }

        return $news ?? [];
    }

    public function d2($code)
    {

    }
}
