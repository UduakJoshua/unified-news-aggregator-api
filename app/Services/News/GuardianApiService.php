<?php

namespace App\Services\News;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Source;

class GuardianApiService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $source = Source::where('slug', 'guardian')->firstOrFail();

        $this->baseUrl = $source->api_url;       
        $this->apiKey = config('services.guardian.api_key') 
                    ?? throw new \Exception('Guardian API key is missing.');
    }

    
    /* Fetch raw articles from Guardian API @return array */
   
    public function fetch(): array
    {
        $response = Http::get($this->baseUrl . '/search', [
            'api-key'       => $this->apiKey,
            'show-fields'   => 'bodyText,trailText,byline',
            'page-size'     => 20,
            'order-by'      => 'newest',
        ]);

        if ($response->failed()) {
            Log::error('Guardian API fetch failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);

            return [];
        }
        
        return $response->json('response.results') ;
    }
}
