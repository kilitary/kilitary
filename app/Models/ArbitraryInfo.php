<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ArbitraryInfo
 *
 * @property int $id
 * @property string|null $user_id
 * @property string|null $tags
 * @property string|null $key
 * @property string|null $ip
 * @property string|null $related
 * @property string|null $priority
 * @property mixed|null $json
 * @property string|null $text
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereRelated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ArbitraryInfo whereUserId($value)
 * @mixin \Eloquent
 */
class ArbitraryInfo extends Model
{
    protected $table = 'arbitrary_info';
    protected $fillable = ['user_id', 'tags', 'key', 'ip', 'priority', 'json', 'text'];
}
