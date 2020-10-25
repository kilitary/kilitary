<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    public static function gayDetected()
    {
        \App\Logger::msg('gay detected');
        $out = shell_exec("/usr/bin/mpg123.bin /home/kilitary/kilitary/storage/mp3/b.mp3");
        \App\Logger::msg('gay: ' . $out);
    }
}
