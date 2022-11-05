<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Abuser
 *
 * @property int $id
 * @property string $ip
 * @property string|null $ua
 * @property string|null $nick
 * @property string|null $reason
 * @property int|null $firewall_in
 * @property string|null $deabusertime
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser query()
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereDeabusertime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereFirewallIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereNick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereUa($value)
 * @mixin \Eloquent
 * @property string|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereCreatedAt($value)
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Abuser whereUpdatedAt($value)
 */
class Abuser extends Model
{
    public $timestamps = false;
    protected $fillable = ['ip', 'reason', 'firewall_in', 'deabusertime', 'ua', 'nick'];
}
