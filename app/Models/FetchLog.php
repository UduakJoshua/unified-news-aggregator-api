<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FetchLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_id',
        'last_fetched_at',
        'status',
    ];

   
    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
