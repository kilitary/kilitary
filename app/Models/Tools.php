<?php

namespace App\Models;

use ipinfo\ipinfo\IPinfo;
use Exception;
use GeoIp2\Exception\GeoIp2Exception;
use const CURLOPT_TIMEOUT;
use const GEOIP_STANDARD;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use const JSON_PRETTY_PRINT;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

class Tools
{
    public static $allKeys = [];

    public static function br2nl($str)
    {
        return preg_replace("#<br\s*?[/ ]*?>#Usmi", "\r\n", $str);
    }

    public static function userGetConfig($key, $default = null)
    {
        $value = Redis::get(self::getUserId() . ':' . $key);

        if(config('site.internal_debug') == true) {
            \App\Logger::msg('userGetConfig(' . self::getUserId() . ':' . $key . ') = ' . $value);
        }

        return $value == null ? $default : $value;
    }

    public static function userSetConfig($key, $value, $ttl = 0)
    {
        $ret = null;
        if($ttl) {
            $ret = Redis::setEx(self::getUserId() . ':' . $key, $ttl, $value);
        } else {
            $ret = Redis::set(self::getUserId() . ':' . $key, $value);
        }

        if(config('site.internal_debug') == true) {
            \App\Logger::msg('userSetConfig(' . self::getUserId() . ':' . $key . ', ttl:' .
                $ttl . ', value:' . $value . ') = ' . (boolean) $ret);
        }

        return $ret;
    }

    public static function userHasConfig($key)
    {
        $value = Redis::get(self::getUserId() . ':' . $key);

        if(config('site.internal_debug') == true) {
            $has = \gettype($value) == "NULL" ? 0 : 1;
            \App\Logger::msg('userHasConfig(' . self::getUserId() . ':' . $key . ') = ' . $has);
        }

        return $value == null ? false : true;
    }

    public static function getItemCost($item)
    {
        static $costs = [];

        if(isset($costs[$item])) {
            return $costs[$item];
        }

        $cost = \DB::table('pages')
            ->select('cost')
            ->where('code', $item)
            ->value('cost');

        $costs[$item] = $cost;

        return (float) $costs[$item];
    }

    public static function ipVisits()
    {
        return Redis::llen(request()->ip() . ':ip_log_ids');
    }

    public static function isGay($ip)
    {
        return \App\Gay::where('ip', $ip)
            ->exists();
    }

    public static function isProbablyGay()
    {
        return intval(self::userGetConfig('probably_gay'));
    }

    public static function ipInfo($ip)
    {
        $info = Redis::get($ip . ':info', null);
        if(empty($info)) {
            $info = \App\IpInfo::firstWhere('ip', $ip);
            if(!$info || empty($info->info)) {
                $info = 'details: #empty/secured#';
            } else {
                $info = \json_encode(\json_decode($info->info), JSON_PRETTY_PRINT);
                $info = \str_replace('"', "'", $info);
            }

            Redis::setEx($ip . ':info', 3600, $info);
        }
        return $info;
    }

    public static function recordIp($ip)
    {
        \DB::table('ip_info')
            ->insertOrIgnore([
                'ip' => $ip
            ]);
    }

    public static function titleize($string)
    {
        $str = strip_tags($string);
        $str = \preg_replace("#(\s{2,}?)#Usmi", ' ', $str);
        $str = \substr_replace($str, ['"', ' '], ' ', 0);
        $str = \Str::substr($str, 0, 155);

        return trim($str, " \t\n\r\0\x0B\"'") . '...';
    }

    public static function pushKey($key)
    {
        $key = trim(\strip_tags(trim($key)));
        if(strlen($key) && $key != 'br/') {
            self::$allKeys[] = $key;
        }
    }

    public static function getArrayKeys($max = 9)
    {
        return collect(self::$allKeys)->take($max);
    }

    public static function getKeys()
    {
        return \implode(' ', self::$allKeys);
    }

    public static function getUserId()
    {
        $id = request()->ip();
        return $id;
    }

    public static function addToCart($item)
    {
        Redis::sadd(\request()->ip() . ':cart_items', $item);
    }

    public static function arbitraryInfo($info): \App\Models\ArbitraryInfo
    {
        $info['ip'] = \request()->ip();
        $info['user_id'] = self::getUserId();

        \App\Logger::msg(\request()->ip() . '> creating new AI: ' . \json_encode($info, JSON_PRETTY_PRINT));

        try {
            $ai = ArbitraryInfo::create($info);
        } catch(Exception $e) {
            \App\Logger::msg('Exception with ai: ' . $e->getMessage());
        }

        return $ai ?? false;
    }

    public static function clearCart()
    {
        return Redis::del(\request()->ip() . ':cart_items');
    }

    public static function getCart()
    {
        static $items;

        if($items != null) {
            return $items;
        }

        $items = Redis::smembers(\request()->ip() . ':cart_items');

        if($items) {
            \Debugbar::addMessage('cart items: ' . ($items ? count($items) : 0));
        }

        return $items ?? [];
    }

    public static function getCountry($ip)
    {
        $info = Cache::remember($ip . ':info', 3600, function() use ($ip) {
            return \DB::table('ip_info')
                ->select('info->country_name as country_name')
                ->where('ip', $ip)
                ->first();
        });

        return $info == null ? '#unresolved#' : $info->country_name;
    }

    public function codeDeleted($code)
    {
        return \in_array($code, session('currentDeleted'));
    }

    public static function IsAdmin()
    {
        if(session('admin', false) === true)
            return true;

        return env('ADMIN_IP') === \request()->ip();
    }

    public static function savePage(\App\Models\Page $page)
    {
        $api_dev_key = env('PASTEBIN_KEY');
        $api_user_name = 'deconff';
        $api_user_password = 'n3t1sn3tn3t1sn3t';
        $api_user_name = urlencode($api_user_name);
        $api_user_password = urlencode($api_user_password);
        $ch = curl_init('https://pastebin.com/api/api_login.php');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'api_dev_key=' . $api_dev_key . '&api_user_name=' . $api_user_name . '&api_user_password=' .
            $api_user_password . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);

        $key = curl_exec($ch);

        $api_dev_key = env('PASTEBIN_DEV_KEY'); // your api_developer_key
        $api_paste_code = $page->content; // your paste text
        $api_paste_private = 0; // 0=public 1=unlisted 2=private
        $api_paste_name = $page->header; // name or title of your paste
        $api_paste_expire_date = '1Y';
        $api_paste_format = 'text';
        $api_user_key = $key; // if an invalid or expired api_user_key is used, an error will spawn. If no api_user_key is used, a guest paste will be created
        $api_paste_name = urlencode($api_paste_name);
        $api_paste_code = urlencode($api_paste_code);

        $ch = curl_init('https://pastebin.com/api/api_post.php');

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'api_option=paste&api_user_key=' . $api_user_key . '&api_paste_private=' . $api_paste_private .
            '&api_paste_name=' . $api_paste_name . '&api_paste_expire_date=' . $api_paste_expire_date . '&api_paste_format=' . $api_paste_format .
            '&api_dev_key=' . $api_dev_key . '&api_paste_code=' . $api_paste_code . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_NOBODY, 0);

        $data = curl_exec($ch);
        dd($data);
        return;
    }
}
