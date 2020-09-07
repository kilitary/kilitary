<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Logger
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Logger newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Logger newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Logger query()
 * @mixin \Eloquent
 */
class Logger extends Model
{
    public static function msg(...$msgs)
    {
        foreach($msgs as $msg) {
            if(\is_array($msg) || \is_object($msg)) {
                $msg = \json_encode($msg, JSON_PRETTY_PRINT);
            }
            $fp = @fopen(env('LOG_FILE'), 'a');
            if($fp) {
                @fwrite($fp, $msg . PHP_EOL);
                @fclose($fp);
            }
        }
    }
}
