<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redis;

class ChannelStatusProvider extends ServiceProvider
{
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

        $exist = Redis::sismember('channel_known_signs', $inputSalt);
        if($exist) {
            abort(403);
        }

        Redis::sadd('channel_known_signs', $inputSalt);

        $key = 'zdfheufhghuh34g8u';

        $sign = hash('sha512', $inputSalt . $key);

        return $sign;
    }
}
