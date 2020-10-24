<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Gay
 *
 * @property int $id
 * @property string $ip
 * @property string|null $ua
 * @property string|null $nick
 * @property string|null $reason
 * @property int|null $firewall_in
 * @property string|null $degaytime
 * @method static \Illuminate\Database\Eloquent\Builder|Gay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gay query()
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereDegaytime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereFirewallIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereNick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gay whereUa($value)
 * @mixin \Eloquent
 */
class Gay extends Model
{
    public $timestamps = false;
    protected $fillable = ['ip', 'reason', 'firewall_in', 'degaytime', 'ua', 'nick'];
}
