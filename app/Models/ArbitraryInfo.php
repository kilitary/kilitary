<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArbitraryInfo extends Model
{
    protected $table = 'arbitrary_info';
    protected $fillable = ['user_id', 'tags', 'key', 'ip', 'priority', 'json', 'text'];
}
