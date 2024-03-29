<?php
declare(strict_types=1);

namespace App;

use Exception;
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
        try {
            foreach ($msgs as $msg) {
                if (\is_array($msg) || \is_object($msg)) {
                    $msg = \json_encode($msg, JSON_PRETTY_PRINT);
                }
                $fp = fopen(env('LOG_FILE_DEBUG'), 'a');
                if ($fp) {
                    $at = \Carbon::now()->format('Y-m-d H:i:s.u');
                    fwrite($fp, '[' . sprintf("%06d", getmypid()) . '] ' . $at . ' ' . env('APP_NAME') . ': ' . $msg . PHP_EOL);
                    fclose($fp);
                }
            }
        } catch (Exception $e) {
            \Log::critical('fail to use Logger::msg(): ' . $e->getMessage());
        }
    }

    public static function err(...$msgs)
    {
        try {
            foreach ($msgs as $msg) {
                if (\is_array($msg) || \is_object($msg)) {
                    $msg = \json_encode($msg, JSON_PRETTY_PRINT);
                }
                $fp = fopen(env('LOG_FILE_ERROR'), 'a');
                if ($fp) {
                    $at = \Carbon::now()->format('Y-m-d H:i:s.u');
                    fwrite($fp, '[' . sprintf("%06d", getmypid()) . '] ' . $at . ' ' . env('APP_NAME') . ': ' . $msg . PHP_EOL);
                    fclose($fp);
                }
            }
        } catch (Exception $e) {
            \Log::critical('fail to use Logger::err(): ' . $e->getMessage());
        }
    }
}
