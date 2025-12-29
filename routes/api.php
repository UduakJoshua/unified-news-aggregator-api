<?php

use Illuminate\Support\Facades\Route;
use App\Services\News\GuardianApiService;
use App\Services\News\NewsApiService;
use App\Services\News\AggregatorService;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-guardian', function (AggregatorService $aggregator) {
    $aggregator->fetchAndStoreGuardian();
    return 'Guardian articles fetched and stored!';
});

Route::get('/test-newsapi', function (AggregatorService $aggregator) {
        $aggregator->fetchAndStoreNewsApi('technology');
    return response()->json([
        'message' => 'NewsAPI articles fetched and stored successfully!'
    ]);
});

Route::get('/debug/guardian', function (GuardianApiService $service) {
    return response()->json(
        $service->fetch()
    );
});

Route::get('/debug/newsapi', function (NewsApiService $service, ?string $query = "technology") {
    return response()->json(
        $service->fetch($query)
    );
});


