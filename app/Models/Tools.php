<?php

namespace App\Models;

use ipinfo\ipinfo\IPinfo;
use Exception;
use GeoIp2\Exception\GeoIp2Exception;
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
}
