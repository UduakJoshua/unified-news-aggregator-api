<?php

namespace App\Services\News;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleQueryService
{
    public function search(Request $request)
    {
        $query = Article::query()
            ->with(['source', 'category']);

        
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->q}%")
                  ->orWhere('content', 'like', "%{$request->q}%");
            });
        }
       
        if ($request->filled('source')) {
            $query->whereHas('source', function ($q) use ($request) {
                $q->where('slug', $request->source);
            });
        }

      
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

      
        if ($request->filled('from')) {
            $query->whereDate('published_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('published_at', '<=', $request->to);
        }

        return $query
            ->orderByDesc('published_at')
            ->paginate(
                $request->integer('per_page', 20)
            );
    }
}
