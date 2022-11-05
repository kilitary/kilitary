<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\News
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $source
 * @property int|null $views
 * @property int|null $visible
 * @property int|null $added_by
 * @property string|null $content
 * @property string|null $url
 * @property string|null $category_name_old
 * @property int|null $category_id
 * @property int|null $length
 * @property string|null $deleted_at
 * @property float|null $cost
 * @property string|null $published_at
 * @property string|null $image_url
 * @property string|null $hash
 * @property string|null $description
 * @property string|null $prog_at
 * @property string|null $prog_code
 * @property int|null $prog_ok
 * @property int|null $prog_bad
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCategoryNameOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereProgAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereProgBad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereProgCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereProgOk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereVisible($value)
 * @mixin \Eloquent
 */
class News extends Model
{
    public $table = 'news';
    protected $fillable = ['content', 'title', 'url', 'category_name_old',
        'length', 'source', 'visible', 'added_by', 'cost', 'published_at', 'slug',
        'image_url', 'hash', 'description', 'category_id', 'views', 'prog_code', 'prog_at', 'prog_bad', 'prog_ok'
    ];
}
