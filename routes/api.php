<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Api\NewsIngestionController;


/* API Routes for frontend consumption */
Route::get('/articles', [ArticleController::class, 'index']);

/* API Route for news ingestion only for internal/ testing purposes */
Route::get('/ingest-news', [NewsIngestionController::class, 'ingest']);