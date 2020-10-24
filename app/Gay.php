<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gay extends Model
{
    public $timestamps = false;
    protected $fillable = ['ip', 'reason', 'firewall_in', 'degaytime', 'ua', 'nick'];
}
