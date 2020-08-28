<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Logger;

class XRandom
{
    public static function followRand()
    {
        for($i = 0; $i < mt_rand(0, 3); $i++) {
            $m = mt_rand(0, 255);
            \file_put_contents('/dev/null', $m);
        }
    }

    public static function get($min, $max)
    {
        return mt_rand($min, $max);
    }

    public static function sign($max)
    {
        return Str::random($max);
    }

    public static function getAu($numBytes)
    {
        $stepSection = '';
        $fp = @fopen('/dev/random', 'rb');
        if($fp !== false) {
            $bytes = fread($fp, $numBytes);
            Logger::msg('read ' . strlen($bytes) . ' bytes of random');
            $stepSection .= sprintf("%x", $bytes);
            fclose($fp);
        } else {
            die("/dev/random: cannot read $numBytes bytes.");
        }

        return $stepSection;
    }
}
