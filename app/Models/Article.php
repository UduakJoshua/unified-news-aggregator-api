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

    public function scopeFilter($query, Request $request)
    {
        $request->validate([
            'q'        => 'nullable|string|max:255',
            'category' => 'nullable|string|exists:categories,slug',
            'source'   => 'nullable|string|exists:sources,slug',
            'from'     => 'nullable|date',
            'to'       => 'nullable|date|after_or_equal:from',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        if (
            !$request->filled('q') &&
            !$request->filled('category') &&
            !$request->filled('from')&&
            !$request->filled('source') &&
            !$request->filled('to') &&
            !$request->filled('per_page')
        ) {
            return response()->json([
                'message' => 'At least one search or filter parameter is required',
            ], 422);
        }

        // Search keyword
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                    ->orWhere('content', 'like', '%' . $request->q . '%');
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Source filter
        if ($request->filled('source')) {
            $query->whereHas('source', function ($q) use ($request) {
                $q->where('slug', $request->source);
            });
        }

        // Date range filters
        if ($request->filled('from')) {
            $query->whereDate('published_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('published_at', '<=', $request->to);
        }

        return $query;
    }
}
