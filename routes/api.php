<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Api\NewsController;


// routing for the endpoint for the frontend to get aggregated news articles
Route::get('/articles', [ArticleController::class, 'index']);

// API routes for triggering news fetch from different sources for testing purposes
Route::prefix('news')->group(function () {
    Route::get('/guardian', [NewsController::class, 'fetchGuardian']);
    Route::get('/newsapi', [NewsController::class, 'fetchNewsApi']);
});