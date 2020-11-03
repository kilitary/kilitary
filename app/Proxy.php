<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    protected $fillable = ['host', 'ip', 'type', 'checked_at', 'anonymity'];
    public $table = 'proxys';
    protected $dates = ['checked_at', 'added_at'];
}
