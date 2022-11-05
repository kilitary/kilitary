<?php
declare(strict_types=1);

namespace App;

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
