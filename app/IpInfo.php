<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpInfo extends Model
{
    protected $table = 'ip_info';
    protected $fillable = ['ip', 'type', 'data', 'info'];

}
