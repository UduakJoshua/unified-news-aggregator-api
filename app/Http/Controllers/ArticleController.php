<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Services\News\ArticleQueryService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct(
        protected ArticleQueryService $articleQueryService
    ) {}

    public function index(Request $request)
    {
        $articles = $this->articleQueryService->search($request);

        return ArticleResource::collection($articles);
    }
}
