<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogRecord extends Model
{
    protected $table = 'logs';
    protected $fillable = ['ip', 'method', 'url', 'ua', 'info', 'http_code'];
}
