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
    public static function gayDetected()
    {
        `/usr/bin/mpg123.bin /home/kilitary/kilitary/storage/mp3/b.mp3`;
    }
}
