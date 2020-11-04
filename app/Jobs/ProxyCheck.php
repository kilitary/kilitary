<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Clue\React\Socks;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server;
use React\Socket\Connector;

class ProxyCheck implements ShouldQueue
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
            ->get();

        \App\Logger::msg('job: proxy check started with ' . $proxys->count() . ' records');

        ini_set("default_socket_timeout", 3);
        foreach($proxys as $proxy) {
            \App\Logger::msg('[proxy check] testing ' . $proxy->host . ':' . $proxy->port);
            $loop = \React\EventLoop\Factory::create();
            $connector = new \React\Socket\Connector($loop, [
                'dns' => true,
                'tls' => false,
                'timeout' => true
            ]);

            $loop->addPeriodicTimer('1', function() {
                \App\Logger::msg(\App\XRandom::get(0, 1) ? 'tick' : 'tack');
            });
            //$client = new \Clue\React\Socks\Client($proxy->host . ':' . $proxy->port, $connector);
            $client = new \Clue\React\Socks\Client('127.0.0.1:9050', $connector);

            $loop->addSignal(SIGINT, function() {
                \App\Logger::msg('signal received');
            });

            $client->connect('tcp://kilitary.ru:80')->then(function(ConnectionInterface $stream) {
                \App\Logger::msg('writing to stream ...');
                $stream->write("GET / HTTP/1.1\r\n\r\n");
                \App\Logger::msg('reading stream ...');
                $data = $stream->readStringNull();
                dump($data);
            });

            $loop->run();

            dump($loop);
        }

        \App\Logger::msg('job: proxy check ended');
    }
}
