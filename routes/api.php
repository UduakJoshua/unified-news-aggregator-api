<?php

use Illuminate\Support\Facades\Route;
use App\Services\News\GuardianApiService;
use App\Services\News\AggregatorService;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-guardian', function (AggregatorService $aggregator) {
    $aggregator->fetchAndStoreGuardian();
    return 'Guardian articles fetched and stored!';
});

Route::get('/debug/guardian', function (GuardianApiService $service) {
    return response()->json(
        $service->fetch()
    );
});

