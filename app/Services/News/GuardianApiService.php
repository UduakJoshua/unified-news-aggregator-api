<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GuardianApiService
{
    protected string $baseUrl = 'https://content.guardianapis.com';
    protected string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.guardian.key');
    }

    
    public function fetch(): array
    {
        $response = Http::get($this->baseUrl . '/search', [
            'api-key' => $this->apiKey,
            'show-fields' => 'body,trailText,byline',
            'page-size' => 20,
            'order-by' => 'newest',
        ]);

        if ($response->failed()) {
            Log::error('Guardian API fetch failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [];
        }

        return $response->json('response.results') ?? [];
    }
}
