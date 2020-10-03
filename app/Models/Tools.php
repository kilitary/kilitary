<?php

namespace App\Models;

use const GEOIP_STANDARD;

class Tools
{
    public static function getCountry($ip)
    {
        $gi = geoip_open("/usr/share/GeoIP/GeoIP.dat", GEOIP_STANDARD);
        $country = geoip_country_name_by_addr($gi, $request->ip());
        geoip_close($gi);

        return $country;
    }

    public function codeDeleted($code)
    {
        $deleted = session('currentDeleted');

        if(\in_array($code, $deleted)) {
            return true;
        }

        return false;
    }

    public static function IsAdmin()
    {
        return session('admin', false);
    }
}
