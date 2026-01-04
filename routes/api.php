<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MetaController;



/* API Routes for frontend consumption */
Route::get('/articles', [ArticleController::class, 'index']);

/* Meta information routes to expose supported source and categories to the FE*/
Route::get('/sources', [MetaController::class, 'sources']);

Route::get('/categories', [MetaController::class, 'categories']);