<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Video
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $category_old_name
 * @property int|null $category_id
 * @property string|null $tags
 * @property string|null $html
 * @property float|null $length
 * @property string|null $url
 * @property string|null $description
 * @property int|null $views
 * @property string $code
 * @method static \Illuminate\Database\Eloquent\Builder|Video newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Video query()
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCategoryOldName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Video whereViews($value)
 * @mixin \Eloquent
 */
class Video extends Model
{
    use HasFactory;

    public static function getLatest($limit = 5)
    {
        $videos = self::limit($limit)
            ->get();

        return $videos;
    }
}
