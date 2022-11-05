<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redis;

class ChannelStatusProvider extends ServiceProvider
{
    protected $key = 'zdfheufhghuh34g8u1';

    public function __construct()
    {
        $this->app = app();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    public function sign()
    {
        $inputSalt = \request()->get('input_string');

        if(empty($inputSalt)) {
            return '!full!';
        }

        $exist = Redis::sismember('channel_known_signs', $inputSalt);
        if($exist) {
            \App\Logger::msg('fatal sign: check already done for ' . \request()->ip() . ' inputSalt: ' . $inputSalt);
            \Tools::userSetValue('terminate_fatal_sign', 1, 2);
            return '!empty!';
        }

        Redis::sadd('channel_known_signs', $inputSalt);

        if(\Illuminate\Support\Str::contains($inputSalt, '8')) {
            \App\Logger::msg('warning sign: out-of-table ip: ' . \request()->ip() . ' inputSalt: ' . $inputSalt);
            \Tools::userSetValue('terminate_fatal_sign', 1, 2);

            $sign = hash('sha512', $inputSalt . $this->key);

            return $sign;
        }

        $sign = hash('sha512', $inputSalt . $this->key);

        return $sign;
    }
}
