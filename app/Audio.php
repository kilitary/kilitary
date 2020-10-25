<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    public static function gayDetected()
    {
        \App\Logger::msg('gay detected');
        $out = `/usr/bin/mpg123.bin ../storage/b.mp3`;
    }
}
