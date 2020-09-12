<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TextSource
{
    public static function all()
    {
        return file("../american-english-huge");
    }

    public static function one()
    {
        $words = file("../american-english-huge");
        return $words[XRandom::get(0, count($words) - 1)];
    }
}
