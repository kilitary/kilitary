<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    public $table = 'news';
    protected $fillable = ['content', 'title', 'url', 'category_name_old',
        'length', 'source', 'visible', 'added_by', 'cost', 'published_at', 'slug',
        'image_url', 'hash', 'description', 'category_id', 'views', 'prog_code', 'prog_at', 'prog_bad', 'prog_ok'
    ];
}
