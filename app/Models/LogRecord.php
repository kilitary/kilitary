<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LogRecord
 *
 * @property int $id
 * @property string|null $http_code
 * @property string|null $method
 * @property string|null $url
 * @property string $ip
 * @property string|null $ua
 * @property string $info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereHttpCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereUa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LogRecord whereUrl($value)
 * @mixin \Eloquent
 */
class LogRecord extends Model
{
    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
        'deleted_at' => 'datetime:Y-m-d h:i:s'
    ];
    protected $table = 'logs';
    protected $fillable = ['ip', 'method', 'url', 'ua', 'info', 'http_code'];
}
