<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XRandom
{
    public static function followRand()
    {
        for($i = 0; $i < mt_rand(0, 3); $i++) {
            $m = mt_rand(0, 65535);
            \file_put_contents('/dev/null', $m);
        }
    }

    public static function get($max)
    {
        return mt_rand(0, $max);
    }
}
