<?php

namespace App\Models;

use Exception;
use GeoIp2\Exception\GeoIp2Exception;
use const GEOIP_STANDARD;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class Tools
{
    public static function getCountry($ip)
    {
        try {
            $reader = new Reader('/usr/share/GeoIP/GeoIP2-Country.mmdb');

            $record = $reader->country($ip);
            $country = $record->country->name;
        } catch(Exception  $e) {
            return '<unknown>';
        }
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
