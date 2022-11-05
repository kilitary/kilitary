<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\IpInfo
 *
 * @property int $id
 * @property string $ip
 * @property string|null $type
 * @property string|null $info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IpInfo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class IpInfo extends Model
{
    protected $table = 'ip_info';
    protected $fillable = ['ip', 'type', 'data', 'info'];

}
