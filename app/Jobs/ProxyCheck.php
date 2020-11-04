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
use React\Socket\ConnectionInterface;

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
            ->limit(2)
            ->get();

        \App\Logger::msg('job: proxy check started with ' . $proxys->count() . ' records');

        ini_set("default_socket_timeout", 31);

        foreach($proxys as $proxy) {
            \App\Logger::msg('[proxy check] testing ' . $proxy->host . ':' . $proxy->port);
            $loop = \React\EventLoop\Factory::create();
            $connector = new \React\Socket\Connector($loop, [
                'dns' => true,
//                'tls' => false,
                'tcp' => true,
//                'timeout' => true
            ]);

            $loop->addPeriodicTimer(60.0, function() use ($loop) {
                \App\Logger::msg('stopping scan');
                $loop->stop();
            });

            $loop->addSignal(SIGINT, function() {
                \App\Logger::msg('signal received');
            });

            //$client = new \Clue\React\Socks\Client('socks://' . $proxy->host . ':' . $proxy->port, $connector);
            $client = new \Clue\React\Socks\Client('socks5://98.190.102.62:4145', $connector);

            $client->connect('tcp://kilitary.ru:80')->then(function(ConnectionInterface $stream) {
                \App\Logger::msg('writing to stream ...');
                $stream->write("GET / HTTP/1.0\r\nHost: kilitary.ru\r\n\r\n");
                \App\Logger::msg('reading stream ...');
                $stream->on('read', function($data) {
                    \App\Logger::msg('>' . $data);
                });
                $data = $stream->readBufferCallback(function($buffer) {
                    \App\Logger::msg('>' . $buffer);
                });

            });

            //dump($loop);
        }

        $loop->run();
        dump($loop);

        \App\Logger::msg('job: proxy check ended');
    }
}
