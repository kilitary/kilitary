<?php

namespace App;

use App\Models\Tools;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Comment
 *
 * @property int $id
 * @property int $page_id
 * @property string $comment
 * @property string $ip
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereUsername($value)
 * @mixin \Eloquent
 * @property string $country
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereCountry($value)
 * @property string|null $info
 * @method static \Illuminate\Database\Eloquent\Builder|Comment whereInfo($value)
 * @property-read \App\Models\Page $page
 */
class Comment extends Model
{
    protected $casts = [
        'created_at' => 'datetime:d-m-Y h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s',
        'deleted_at' => 'datetime:Y-m-d h:i:s'
    ];
    protected $fillable = ['comment', 'email', 'ip', 'page_id', 'username',
        'country', 'info', 'prefix'];

    public function page()
    {
        return $this->belongsTo(\App\Models\Page::class);
    }

    public static function getLatest($take = 5)
    {
        $comments = \App\Comment::select('id', 'comment', 'page_id',
            'created_at', 'username', 'prefix')
            ->limit($take)
            ->orderBy('id', 'DESC')
            ->get();

        $comms = $comments;
        foreach ($comms as &$item) {
            $item->cost = hexdec(XRandom::getAu(1)) / 25;
        }
            $item->cost = hexdec(XRandom::getAu(1)) / 25;
            $item->created_at_diff = $item->created_at->to(null, \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW);
            $item->created_at_diff = \str_replace(
                ["minutes from now", "hours from now", "hours ago", "seconds from now", "hour from now",
                    "minute from now"],
                ["минут назад", "часов назад", "часа назад", "секунд назад", "час назад",
                    "минуты назад"],
                $item->created_at_diff);
        }

        return $comms;
    }
}
