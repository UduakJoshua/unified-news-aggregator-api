<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Api\NewsController;
use App\Services\News\AggregatorService;
use App\Http\Controllers\Api\NewsIngestionController;

Route::get('/', function () {
    return response()->json(['message' => 'API is running']);
});
// routing for the endpoint for the frontend to get aggregated news articles
//Route::get('/articles', [ArticleController::class, 'index']);


Route::get('/articles', [AggregatorService::class, 'run']);

/*API routes for triggering news fetch from different sources for testing purposes*/
Route::prefix('news')->group(function () {
    Route::get('/guardian', [NewsController::class, 'fetchGuardian']);
    Route::get('/newsapi', [NewsController::class, 'fetchNewsApi']);
});

Route::get('/ingest-news', [NewsIngestionController::class, 'ingest']);