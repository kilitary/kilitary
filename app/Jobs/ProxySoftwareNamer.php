<?php
declare(strict_types=1);

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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

        foreach ($proxys as $proxy) {
            try {
                $proxy->checked_at = \Carbon::now();
                \App\Logger::msg('going with ' . $proxy->host . ':' . $proxy->port);

                $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
                socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, ["sec" => 25, "usec" => 0]);
                socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, ["sec" => 25, "usec" => 0]);
                socket_set_block($socket);
                //socket_set_option($socket, SOL_SOCKET, TCP_NODELAY, 1);
                \App\Logger::msg('connecting ...');

                // TODO: do better check
                //$ret = 0;
                //do {
                $start = time();
                $ret = socket_connect($socket, $proxy->host, $proxy->port);
                if ($ret) {
                    \App\Logger::msg('connected in ' . (time() - $start) . ' secs');
                } else {
                    \App\Logger::msg('error: ' . socket_strerror(socket_last_error()) . ' (#' . socket_last_error() . ')');
                    $proxy->last_error = socket_last_error();
                    $proxy->save();
                    continue;
                }
                //} while($ret == 115 || $ret != true);

                $nullSocket = [];
                $readSockets = [$socket];
                $writeSockets = [$socket];
                $numSocketsReady = socket_select($nullSocket, $writeSockets, $nullSocket, 4);

                $buf = "GET http://ip.kilitary.ru/self HTTP/1.1\r\n" .
                    "Accept-Language: en-US,en;q=0.9,ru;q=0.8,pl;q=0.7,de;q=0.6,ja;q=0.5" . "\r\n" .
                    "Cache-Control: no-cache" . "\r\n" .
                    "Accept: text/html,text/plain,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9" . "\r\n" .
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36 Edg/82.0.622.62\r\n\r\n";

                socket_set_block($socket);
                $sent = socket_send($socket, $buf, strlen($buf), 0);

                \App\Logger::msg('sent ' . $sent);

                $numSocketsReady = socket_select($readSockets, $nullSocket, $nullSocket, 25);

                do {
                    $recv = socket_recv($socket, $buf, 32768, 0);
                    if ($recv) {
                        \App\Logger::msg('recv ' . strlen($buf), $buf);
                    } else {
                        $proxy->last_error = socket_last_error();
                        $proxy->save();
                        break;
                    }

                    $n = preg_match("#^Server:\s+(.*?)$#sUumi", $buf, $matches);
                    if ($n) {
                        $proxy->software = \Str::substr($matches[1], 0, 255);
                        $proxy->save();
                    }

                    $n = preg_match("#http/#smi", $buf, $matches);
                    if ($n) {
                        $proxy->software = 'unknown';
                        $proxy->save();
                    }

                    $n = preg_match("#http/\d\.\d\s+(\d+)\s+#sUumi", $buf, $matches);
                    if ($n) {
                        $proxy->last_code = $matches[1];
                        $proxy->save();
                    }

                    $id = hash('sha256', $proxy->host . "--");
                    $n = preg_match("#{$id}#sUumi", $buf, $matches);
                    if ($n) {
                        \App\Logger::msg('id ' . $id . ' found');
                        $proxy->self = $buf;
                        $proxy->save();
                    }

                    $n = preg_match("#(?:forwarded\-for|via)#Uusmi", $buf, $matches);
                    if ($n) {
                        \App\Logger::msg('proxy is fully transparent');
                        $proxy->self = $buf;
                        $proxy->save();
                    }

                } while ($recv);

                if ($recv === false) {
                    $proxy->last_error = socket_last_error();
                    $proxy->save();
                    \App\Logger::msg('connection dropped');
                } elseif ($recv == 0) {
                    \App\Logger::msg('connection closed gracefully');
                } else {
                    \App\Logger::msg('connection closed unexpetdly');
                }

            } catch (Exception $e) {
                \App\Logger::msg('exception: ' . $e->getMessage());
            }
        }

        \App\Logger::msg('job: proxy software checker ended');
    }
}
