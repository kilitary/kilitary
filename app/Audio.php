<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Audio
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Audio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Audio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Audio query()
 * @mixin \Eloquent
 */
class Audio extends Model
{
    public static function exception()
    {
        if(!env('AUDIO_ENABLED')) {
            return;
        }

        $ret = exec('/usr/bin/ffplay -volume 100 -autoexit -vn -nodisp /home/kilitary/kilitary/storage/mp3/explode_8.mp3 &');
    }

    public static function gayDetected()
    {
        if(!env('AUDIO_ENABLED')) {
            return;
        }

        $ret = exec('/usr/bin/ffplay -volume 8 -autoexit -vn -nodisp /home/kilitary/kilitary/storage/mp3/wickedsick.mp3');
    }

    public static function gayRedirected()
    {
        if(!env('AUDIO_ENABLED')) {
            return;
        }

        $ret = exec('/usr/bin/ffplay -volume 8 -autoexit -vn -nodisp /home/kilitary/kilitary/storage/mp3/wickedsick.mp3');
    }
}
