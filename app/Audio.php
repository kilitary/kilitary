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
        if(env('AUDIO_ENABLED') != 'true') {
            return;
        }

        $ret = exec('/usr/bin/ffplay -volume 100 -autoexit -vn -nodisp /home/kilitary/kilitary/storage/mp3/explode_8.mp3 &');
    }

    public static function abuserDetected()
    {
        if(env('AUDIO_ENABLED') != 'true') {
            return;
        }

        $ret = exec('/usr/bin/ffplay -volume 18 -autoexit -vn -nodisp /home/kilitary/kilitary/storage/mp3/wickedsick.mp3');
    }

    public static function abuserRedirected()
    {
        if(env('AUDIO_ENABLED') != 'true') {
            return;
        }

        $ret = exec('/usr/bin/ffplay -volume 18 -autoexit -vn -nodisp /home/kilitary/kilitary/storage/mp3/wickedsick.mp3');
    }
}
