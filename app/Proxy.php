<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Proxy
 *
 * @property int $id
 * @property string $host
 * @property int $port
 * @property string|null $type
 * @property string $anonymity
 * @property string|null $source
 * @property string|null $speed
 * @property string|null $info
 * @property string|null $software
 * @property \Illuminate\Support\Carbon|null $checked_at
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy query()
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereAnonymity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereCheckedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereSoftware($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereType($value)
 * @mixin \Eloquent
 * @property int|null $last_error
 * @property int|null $last_code
 * @property string|null $self
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereLastCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereLastError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereSelf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Proxy whereUpdatedAt($value)
 */
class Proxy extends Model
{
    protected $fillable = ['host', 'ip', 'type', 'checked_at', 'anonymity'];
    public $table = 'proxys';
    protected $dates = ['checked_at', 'added_at', 'updated_at'];
    public $timestamps = true;
}
