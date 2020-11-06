<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class FetchProxy implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \DB::table('proxys')
            ->truncate();

        \App\Logger::msg('running job [fetch proxy]');

        $start = 0;
        do {
            $foundProxys = 0;
            $source = 'hidemy.name';

            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Safari/537.36 Edg/86.0.622.58'
            ])->get('https://hidemy.name/ru/proxy-list/?start=' . $start . '#list');

            $start += 64;

            \App\Logger::msg('index ' . ($start - 64) . ' - ' . $start);

            if($response->status() != 200) {
                \App\Logger::msg($source . ': fetch status => ' . $response->status());
                \App\Logger::msg($response->serverError());
                \App\Logger::msg($response->clientError());
                break;
            }

            $foundProxys = preg_match_all("#<td>(\d{1,3}?\.\d{1,3}?\.\d{1,3}?\.\d{1,3}?)<.*?<td>(\d{1,5}).*?(so\w+|htt\w+).*?<#mi", $response->body(), $mm, \PREG_SET_ORDER);

            foreach($mm as $match) {
                \App\Logger::msg($source . ': found proxy type ' . $match[3] . ' ' . $match[1] . ':' . $match[2]);

                \DB::table('proxys')
                    ->updateOrInsert([
                        'host' => $match[1],
                    ], [
                        'port' => $match[2],
                        'source' => $source,
                        'type' => \Str::lower($match[3]),
                        'software' => null
                    ]);

                \DB::table('ip_info')
                    ->insertOrIgnore([
                        'ip' => $match[1]
                    ]);
            }
        } while($foundProxys > 0 && $start <= 130);

        \App\Logger::msg('done job [fetch proxy]');
    }
}
