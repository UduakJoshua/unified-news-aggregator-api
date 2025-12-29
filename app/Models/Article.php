<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'url',
        'published_at',
        'source_id',
        'category_id',
        'author',
    ];

    /* Article belongs to a source */
    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    /* Article belongs to a category */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
