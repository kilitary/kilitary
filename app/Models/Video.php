<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
