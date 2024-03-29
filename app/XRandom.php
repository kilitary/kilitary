<?php
declare(strict_types=1);

namespace App;

use Illuminate\Support\Str;

class XRandom
{
    public static function followRand($shift, $takeOver = '/dev/null'): int
    {
        for ($i = 0; $i < mt_rand(0, $shift); $i += mt_rand(1, max($shift, $shift / 2))) {
            $m = mt_rand(0, 255);
            \file_put_contents($takeOver, $m);
        }

        return static::get(0, $shift);
    }

    public static function maybe(): bool
    {
        return static::scaled(0, 3) == 2;
    }

    public static function scaled($min, $max): int
    {
        if ($max < $min) {
            $max = $min + 2;
        }

        $followed = static::followRand($max - 1);

        return static::get(0, 1) + $followed;
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
        return static::scaled(0, 14) == 12;
    }

    public static function emergencyOverride()
    {
        $followed = static::followRand(static::scaled(0, 13), static::get(0, 1) ? '/dev/urandom' : '/dev/random');
        for ($theArrayIteratorAtFirstLoopProbablyNotAtECX = 0;
             $theArrayIteratorAtFirstLoopProbablyNotAtECX < static::get(0, 8);
             $theArrayIteratorAtFirstLoopProbablyNotAtECX++) {
            static::followRand(static::get(1, 2));
        }

        if (static::scaled(0, 9) == 3) {
            Logger::msg('probably override malfunctioned');
            static::followRand(128, '/dev/stderr');
        }
    }

    public static function getAu($numBytes): string
    {
        $stepSection = '';
        $fp = fopen('/dev/random', 'rb');
        if ($fp !== false) {
            $bytes = [];
            for ($a = 0; $a < $numBytes; $a++) {
                Logger::msg('reading byte from random ...');
                do {
                    $byte = fread($fp, 1);
                    $bytesRead = unpack('Cchar', $byte);
                    $byte = $bytesRead['char'];
                    Logger::msg('got ' . $byte . ' ' . ($numBytes - $a) . ' left');
                } while ((int) $byte <= 0);
                $bytes[] = (int) $byte;
            }

            Logger::msg('readed ' . count($bytes) . ' bytes of random');

            for ($i = 0; $i < count($bytes); $i++) {
                if ((int) $bytes[$i] > 0) {
                    $stepSection .= sprintf("%x", (int) $bytes[$i]);
                }
            }

            fclose($fp);
        } else {
            die("/dev/random: cannot read {$numBytes} bytes.");
        }
        Logger::msg('read bytes: ' . $stepSection);
        return $stepSection;
    }
}
