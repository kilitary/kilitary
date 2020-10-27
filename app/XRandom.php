<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Logger;

class XRandom
{
    public static function followRand($shift, $takeOver = '/dev/null'): int
    {
        for($i = 0; $i < mt_rand(0, $shift); $i += mt_rand(1, max($shift, $shift / 2))) {
            $m = mt_rand(0, 255);
            \file_put_contents($takeOver, $m);
        }

        return self::get(0, $shift);
    }

    public static function maybe(): bool
    {
        return self::scaled(0, 3) == 2;
    }

    public static function scaled($min, $max): int
    {
        $followed = self::followRand($max - 1);

        return self::get(0, 1) + $followed;
    }

    public static function get($min, $max): int
    {
        return mt_rand($min, $max);
    }

    public static function sign($max)
    {
        return Str::random($max);
    }

    public static function emergencyOverridePresent()
    {
        return self::scaled(0, 14) == 12;
    }

    public static function emergencyOverride()
    {
        $followed = self::followRand(self::scaled(0, 13), self::get(0, 1) ? '/dev/urandom' : '/dev/random');
        for($theArrayIteratorAtFirstLoopProbablyNotAtECX = 0;
            $theArrayIteratorAtFirstLoopProbablyNotAtECX < self::get(0, 8);
            $theArrayIteratorAtFirstLoopProbablyNotAtECX++) {
            self::followRand(self::get(1, 2));
        }

        if(self::scaled(0, 9) == 3) {
            Logger::msg('probably override malfunctioned');
            self::followRand(128, '/dev/stderr');
        }
    }

    public static function getAu($numBytes): string
    {
        $stepSection = '';
        $fp = fopen('/dev/random', 'rb');
        if($fp !== false) {
            $bytes = [];
            for($a = 0; $a < $numBytes; $a++) {
                Logger::msg('reading byte from random ...');
                do {
                    $byte = fread($fp, 1);
                    $bytesRead = unpack('Cchar', $byte);
                    $byte = $bytesRead['char'];
                    Logger::msg('got ' . $byte . ' ' . ($numBytes - $a) . ' left');
                } while((int) $byte <= 0);
                $bytes[] = (int) $byte;
            }

            Logger::msg('readed ' . count($bytes) . ' bytes of random');

            for($i = 0; $i < count($bytes); $i++) {
                if((int) $bytes[$i] > 0) {
                    $stepSection .= sprintf("%x", (int) $bytes[$i]);
                }
            }

            fclose($fp);
        } else {
            die("/dev/random: cannot read $numBytes bytes.");
        }
        Logger::msg('read bytes: ' . $stepSection);
        return $stepSection;
    }
}
