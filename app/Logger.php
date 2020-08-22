<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logger extends Model
{
    public static function msg(...$msgs)
    {
        foreach($msgs as $msg) {
            if(\is_array($msg) || \is_object($msg)) {
                $msg = \json_encode($msg, JSON_PRETTY_PRINT);
            }
            $fp = fopen('debug.log', 'a');
            fwrite($fp, $msg . PHP_EOL);
            fclose($fp);
        }
    }
}
