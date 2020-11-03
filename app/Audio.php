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
        $ret = exec('/usr/bin/ffplay --volume 100 -autoexit -vn -nodisp /home/kilitary/kilitary/storage/mp3/explode_8.mp3');
    }

    public static function gayDetected()
    {
        $ret = exec('/usr/bin/ffplay --volume 22 -autoexit -vn -nodisp /home/kilitary/kilitary/storage/mp3/wickedsick.mp3');
    }

    public static function gayRedirected()
    {
        $ret = exec('/usr/bin/ffplay --volume 22 -autoexit -vn -nodisp /home/kilitary/kilitary/storage/mp3/wickedsick.mp3');
    }
}
