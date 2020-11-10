<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProxySoftwareNamer implements ShouldQueue
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
        $proxys = \App\Proxy::whereNull('software')
            ->limit(1111)
            ->whereIn('type', ['http', 'https'])
            ->whereNull('software')
            ->inRandomOrder()
            ->get();

        \App\Logger::msg('job: proxy software checker started with ' . $proxys->count() . ' records');

        foreach($proxys as $proxy) {
            try {
                \App\Logger::msg('going with ' . $proxy->host . ':' . $proxy->port);

                $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ["sec" => 5, "usec" => 0]);
                socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, ["sec" => 5, "usec" => 0]);
                socket_set_block($socket);
                //socket_set_option($socket, SOL_SOCKET, TCP_NODELAY, 1);
                \App\Logger::msg('connecting');

                // TODO: do better check
                //$ret = 0;
                //do {
                $ret = socket_connect($socket, $proxy->host, $proxy->port);
                if($ret == true) {
                    \App\Logger::msg('connected');
                } else {
                    \App\Logger::msg('error: ' . socket_strerror(socket_last_error()) . '(#' . socket_last_error() . ')');
                }
                //} while($ret == 115 || $ret != true);

                if($ret == false) {
                    \App\Logger::msg('failed to connect');
                    continue;
                }

                $nullSocket = [];
                $readSockets = [$socket];
                $writeSockets = [$socket];
                $numSocketsReady = socket_select($nullSocket, $writeSockets, $nullSocket, 10);

                $buf = "GET / HTTP/1.1\r\n" .
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36 Edg/86.0.622.63\r\n\r\n";
                socket_set_block($socket);
                $sent = socket_send($socket, $buf, strlen($buf), 0);
                \App\Logger::msg('sent ' . $sent);
                $numSocketsReady = socket_select($readSockets, $nullSocket, $nullSocket, 10);
                $recv = socket_recv($socket, $buf, 8192, 0);
                \App\Logger::msg('recv ', $buf);

                $n = preg_match("#^Server:\s+(.*?)$#smi", $buf, $matches);
                if($n) {
                    $proxy->software = \Str::substr($matches[1], 0, 255);
                    $proxy->save();
                }

                $n = preg_match("#http/#smi", $buf, $matches);
                if($n) {
                    $proxy->software = 'unknown';
                    $proxy->save();
                }

            } catch(Exception $e) {
                \App\Logger::msg('exception: ' . $e->getMessage());
            }
        }

        \App\Logger::msg('job: proxy software checker ended');
    }
}
