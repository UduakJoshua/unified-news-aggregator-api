<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\News\GuardianApiService;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    protected GuardianApiService $guardianApiService;

    public function __construct(GuardianApiService $guardianApiService)
    {
        $this->guardianApiService = $guardianApiService;
    }

    public function fetchGuardian(): JsonResponse
    {
        $articles = $this->guardianApiService->fetch();

        return response()->json($articles);
    }
}
