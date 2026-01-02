<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
        'external_id',
        'author',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
   
    public function source()
    {
        return $this->belongsTo(Source::class);
    }

  
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

   
}
