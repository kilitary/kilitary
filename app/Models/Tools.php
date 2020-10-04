<?php

namespace App\Models;

use ipinfo\ipinfo\IPinfo;
use Exception;
use GeoIp2\Exception\GeoIp2Exception;
use const CURLOPT_TIMEOUT;
use const GEOIP_STANDARD;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class Tools
{
    public static function getCountry($ip)
    {
        $client = new IPinfo(env('IPINFO_TOKEN'));
        $details = $client->getDetails($ip);
        return $details->all['country_name'] ?? '<unknown>';
    }

    public function codeDeleted($code)
    {
        return \in_array($code, session('currentDeleted'));
    }

    public static function IsAdmin()
    {
        return session('admin', false);
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

        curl_exec($ch);
        return;
    }
}
