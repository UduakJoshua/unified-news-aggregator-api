<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Api\NewsIngestionController;



Route::get('/articles', [ArticleController::class, 'index']);

Route::get('/ingest-news', [NewsIngestionController::class, 'ingest']);