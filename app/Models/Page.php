<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $code
 * @property int $views
 * @property string $content
 * @property string $header
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereViews($value)
 * @mixin \Eloquent
 * @property int|null $edits
 * @property int|null $blocked
 * @property string $ip
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereEdits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereIp($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read int|null $comments_count
 * @property string $country
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCountry($value)
 * @property float|null $cost
 * @property string|null $keywords
 * @property string|null $source_url
 * @property string|null $meta
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereSourceUrl($value)
 * @property string|null $pages
 * @method static \Illuminate\Database\Eloquent\Builder|Page wherePages($value)
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereDeletedAt($value)
 */
class Page extends Model
{
    protected $fillable = ['content', 'cost', 'header', 'visits', 'country', 'ip', 'edits', 'views', 'header', 'active', 'blocked', 'code'];

    public function comments()
    {
        return $this->hasMany('\App\Comment');
    }

    public static function interesting($limit = 5)
    {
        $pages = Page::select('code', 'header', 'content', 'cost')
            //->whereNotIn('code', $deleted)
            ->limit($limit)
            ->orderBy('updated_at', 'desc')
            ->get();

        return $pages;
    }
}
