<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller

{
    public function index(Request $request)
    {
        $articles = Article::with(['source', 'category'])
            ->filter($request)
            ->orderByDesc('published_at')
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'status' => 'success',
            'data'   => $articles->items(),
            'meta'   => [
                'page'      => $articles->currentPage(),
                'per_page' => $articles->perPage(),
                'total'    => $articles->total(),
            ],
            'message' => $articles->isEmpty() ? 'No articles found.' : null
        ]);
    }
}



