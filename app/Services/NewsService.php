<?php

namespace App\Services;

use App\Models\News;
use App\XRandom;
use Illuminate\Support\Facades\Http;
use  Carbon\Carbon;
use App\Models\Tools;
use App\Logger;
use GuzzleHttp\Client;

class NewsService
{
    protected $client;
    protected $url = 'https://www.vedomosti.ru';
    protected $proxy = 'socks5://87.236.146.144:1080';

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->url,
            'timeout' => 111.0,
            'proxy' => $this->proxy
        ]);
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

                $description = $item['description'] ?? '';
                $category = preg_replace("/[^A-Za-zа-яА-Я0-9\s*\!\.\-]/umsiU", "", $item['category'] ?? '');
                $len = $item['enclosure']['@attributes']['length'] ?? -1;
                $imageUrl = $item['enclosure']['@attributes']['url'] ?? '';
                $url = $item['link'];
                $costHash = md5($title ?? '') . ':' . md5($category ?? '') .
                    ':' . md5($len ?? '') . ':' . md5($url ?? '');

                $content = \json_encode($item, JSON_UNESCAPED_UNICODE);

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
                    'cost' => $this->getCost($costHash),
                    'source' => 'vedomosti.ru',
                    'length' => $len
                ]);

                Logger::msg("news id {$news->id} added ({$len} bytes) {$url} {$slug}");

                $totalAdded++;
            }

            return $totalAdded;
        }
    }

    public function getCost($hash)
    {
        if ((XRandom::maybe() && XRandom::scaled(0, 3) == 1) || XRandom::scaled(1, 9) <= 5) {
            Logger::msg("hash input {$hash}");
            $c = max(0, (\substr_count($hash, '2') + \substr_count($hash, '4')) ^ 9);
            Logger::msg("c $c");
            $b = XRandom::scaled(2, max(3, 4 + $c));
            Logger::msg("b $b");
            $min = (-1 + $b);
            Logger::msg("min $min");
            $cost = Xrandom::get(abs($min), abs($min) + mt_rand(0, 12));
            Logger::msg("cost {$cost}");

            if ($cost <= -1) {
                Logger::err('alarm min cost -1 ' . "c $c b $b min $min cost $cost");
            }
        } else {
            $cost = 0.0;
        }
        return $cost;
    }

    public function get($limit, $doFetch = false, $force = false)
    {
        $news = News::limit($limit)
            ->orderBy('published_at', 'DESC')
            ->get();

        if ((count($news) <= 0 && $doFetch) || $force) {
            $added = $this->checkFetchNews($limit, $force);
            if ($added) {
                $news = News::limit($limit)
                    ->get();
            }
        }
        return $news ?? [];
    }
}
