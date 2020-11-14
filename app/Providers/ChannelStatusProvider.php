<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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

        $key = 'zdfheufhghuh34g8u';

        $sign = hash('sha512', $inputSalt . $key);

        return $sign;
    }
}
