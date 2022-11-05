<?php
declare(strict_types=1);

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class IpInfoResolver implements ShouldQueue
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
        \App\Logger::msg('job -> ip info resolve starting');
        $ips = \DB::table('ip_info')
            ->select('ip', 'info')
            ->whereNotIn('ip', ['127.0.0.1'])
            ->whereNull('info')
            ->get();

        foreach ($ips as $ip) {
            \App\Logger::msg('fetching info for ' . $ip->ip);

            $response = Http::get('https://api.ipgeolocation.io/ipgeo', [
                'apiKey' => '9ffd28ec523246bfb5de88ce3c2f5eac',
                'ip' => $ip->ip
            ]);

            if ($response->successful()) {
                $data = $response->body();
                \App\Logger::msg('response: ' . $response->status() . ' data: ' . $data);
                \DB::table('ip_info')
                    ->where('ip', $ip->ip)
                    ->update([
                        'info' => $data,
                        'type' => 'ipgeolocation.io'
                    ]);
            } else {
                \App\Logger::msg('error fetching ip info (' . $response->status() . '): ' . $response->serverError() . ':' . $response->clientError());
            }

            if ($response->status() == 401) {
                \App\Logger::msg('limit reached, sleeping ...');
                break;
            }
        }
        \App\Logger::msg('job -> ip info resolve done');
    }
}
