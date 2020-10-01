<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ShortUrl
 *
 * @property int $id
 * @property string $short
 * @property string $long
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $visits
 * @property string $creater_ip
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereCreaterIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereShort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrl whereVisits($value)
 * @mixin \Eloquent
 */
class ShortUrl extends Model
{
    protected $fillable = ['short', 'long', 'visits', 'creater_ip'];
}
