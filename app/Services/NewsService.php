<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Facades\Http;
use  \Carbon\Carbon;
use GuzzleHttp\Client;

class NewsService
{
    public function fetch($limit)
    {
        $client = new Client([
            'base_uri' => 'https://kilitary.ru/',
            'timeout' => 2.0,
        ]);
        $headers = ['User-Agent', 'aa'];
        $response = $client->request('GET', 'rss/', ['headers' => $headers]);
        return $response;
    }

    public function checkFetchNews($limit)
    {
        if (News::where('created_at', '<', Carbon::now()->subMinutes(3))
                ->count() <= 0) {
            $news = $this->fetch($limit);
            dd($news);
        }
    }

    public function get($limit, $doFetch = false)
    {
        $news = News::limit($limit)
            ->get();

        if (count($news) <= 0 && $doFetch) {
            $this->checkFetchNews($limit);
        }
        return $news;
    }
}
