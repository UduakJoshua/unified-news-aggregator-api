<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\News\GuardianApiService;
use App\Services\News\NewsApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function fetchGuardian(): JsonResponse
    {
        //return response()->json(['message' => 'API is working well']);
        $articles = app(GuardianApiService::class)->fetch();
        return response()->json($articles);
    }

    public function fetchNewsApi(Request $request): JsonResponse
    {
        $articles = app(NewsApiService::class)->fetch(
            $request->query('q')
        );
        return response()->json($articles);
    }
}
