<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Source;

class NewsApiService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $source = Source::where('slug', 'newsapi')->firstOrFail();

        $this->baseUrl = $source->api_url;       
        $this->apiKey = config('services.newsapi.api_key');

        if (!$this->apiKey) {
            throw new \Exception('NewsAPI API key is missing');
        }
    }

    /* Fetch raw articles from NewsAPI @return array */
    public function fetch(?string $query = null, int $pageSize = 20): array
    {
        $params = [
            'apiKey' => $this->apiKey,
            'pageSize' => $pageSize,
        ];

        if ($query) {
            $params['q'] = $query;
        }

        $response = Http::get($this->baseUrl . '/everything', $params);

        if ($response->failed()) {
            Log::error('NewsAPI fetch failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [];
        }

        return $response->json('articles') ?? [];
    }
}
