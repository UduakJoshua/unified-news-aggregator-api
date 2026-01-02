<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\News\UnifiedNewsFetcher;
use App\Services\News\AggregatorService;
use Illuminate\Http\JsonResponse;

class NewsIngestionController extends Controller
{

  
    /**
     * Fetch articles from all registered sources and store them
     */
    public function ingest(
        UnifiedNewsFetcher $fetcher,
        AggregatorService $aggregator
    ): JsonResponse {        
     
        $articles = $fetcher->fetchAll();
      
        $aggregator->store($articles);
     
        return response()->json([
            'status'  => 'success',
            'message' => 'Articles fetched and stored successfully',
            'count'   => count($articles),
        ]);
    }
}
