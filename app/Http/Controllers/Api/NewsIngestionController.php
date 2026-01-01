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

        
        // Fetch articles from all sources using generic fetcher
        $articles = $fetcher->fetchAll();

        // Persist normalized articles to the database
        $aggregator->store($articles);

        // Return a simple JSON response
        return response()->json([
            'status'  => 'success',
            'message' => 'Articles fetched and stored successfully',
            'count'   => count($articles),
        ]);
    }
}
