<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Facades\Http;
use  Carbon\Carbon;
use App\Logger;
use GuzzleHttp\Client;

class NewsService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://tass.ru',
            'timeout' => 8.0,
            'proxy' => 'socks5://kilitary.ru:1080'
        ]);
    }

    public function fetch($limit)
    {
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/106.0.0.0 Safari/537.36 Edg/106.0.1370.52',
            'Referer' => 'https://tass.ru',
            'Accept-Language' => 'en,ru;q=0.9',
            'Cookie' => '__lhash_=6889a3ab80520327caca50b56b3f42c5; Max-Age=604800; Path=/ ',
            'sec-ch-ua' => "\"Chromium\";v = \"106\", \"Microsoft Edge\";v = \"106\", \"Not;A=Brand\";v = \"99\"",
            'sec-ch-ua-mobile' => '?0',
            'sec-ch-ua-platform' => "\"Windows\"",
            'upgrade-insecure-requests' => '1',
            'accept-encoding' => 'gzip, deflate, br',
            'sec-fetch-dest' => 'document',
            'sec-fetch-mode' => 'navigate',
            'sec-fetch-site' => 'same-origin',
            'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
            'sec-fetch-user' => '?1'
        ];

        try {
            $response = $this->client->request('GET', '/rss/anews.xml', [
                'headers' => $headers,
                'version' => 2,
                'debug' => false
            ]);
        } catch (Exception $e) {
            Logger::msg($e->getMessage());
        }

        return $response->getBody()->getContents();
    }

    public function checkFetchNews($limit)
    {
        if (News::where('created_at', '<', Carbon::now()->subMinutes(3))
                ->count() <= 15) {

            $totalAdded = 0;
            $data = $this->fetch($limit);
            $xml = simplexml_load_string($data);
            $json = json_decode(json_encode($xml), true);
            $news = $json['channel']['item'];

            foreach ($news as $item) {
                $pubDate = Carbon::parse($item['pubDate']);
                $title = preg_replace("/[^A-Za-zа-яА-Я0-9\s*\!\.\-]/umsiU", "", $item['title'] ?? '#empty#');
                $category = preg_replace("/[^A-Za-zа-яА-Я0-9\s*\!\.\-]/umsiU", "", $item['category'][0] ?? '#no_category#');
                $len = $item['enclosure']['@attributes']['length'] ?? -1;
                $url = $item['enclosure']['@attributes']['url'] ?? '#no_enclosure#';
                $costHash = md5($title ?? '') . ':' . md5($category ?? '') .
                    ':' . md5($len ?? '') . ':' . md5($url ?? '');

                $news = News::create([
                    'title' => $title,
                    'content' => '#not_explored_yet#',
                    'url' => $url,
                    'published_at' => $pubDate->toDateTimeString(),
                    'category_name_old' => $category,
                    'cost' => $this->getCost($costHash),
                    'source' => 'tass.ru',
                    'length' => $len,
                ]);

                Logger::msg("news id {$news->id} added ({$len} bytes) {$url}");

                $totalAdded++;
            }

            return $totalAdded;
        }
    }

    public function getCost($hash)
    {
        $c = (\substr_count($hash, '2') + \substr_count($hash, '4')) ^ 9;
        $cost = mt_rand(-1, $c * \mt_rand(2, 7));
        Logger::msg("input {$hash} cost {$cost}");
        return $cost;
    }

    public function get($limit, $doFetch = false)
    {
        $news = News::limit($limit)
            ->orderBy('published_at', 'DESC')
            ->get();

        if (count($news) <= 0 && $doFetch) {
            $added = $this->checkFetchNews($limit);
            if ($added) {
                $news = News::limit($limit)
                    ->get();
            }
        }
        return $news ?? [];
    }
}
