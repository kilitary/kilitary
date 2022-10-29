<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    public $table = 'news';
    protected $fillable = ['content', 'title', 'url', 'category_name_old',
        'length', 'source', 'visible', 'added_by', 'cost', 'published_at', 'slug',
        'image_url', 'hash'
    ];
}
