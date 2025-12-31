<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use App\Models\Source;

class FetchNewsApiFeatureTest extends TestCase
{
    use RefreshDatabase;

        public function test_guardian_news_endpoint_returns_articles(): void
        {
            // 1. DB dependency
            Source::create([
                'name'    => 'The Guardian',
                'slug'    => 'guardian',
                'api_url' => 'https://content.guardianapis.com',
            ]);

            // 2. Config dependency
            config([
                'services.guardian.api_key' => 'fake-api-key',
            ]);

            // 3. Mocking up the API response
            Http::fake([
                'https://content.guardianapis.com/search*' => Http::response([
                    'response' => [
                        'results' => [
                            [
                                'webTitle' => 'Test Guardian Article',
                                'webUrl'   => 'https://example.com',
                            ],
                        ],
                    ],
                ], 200),
            ]);

            // 4. Call endpoint
            $response = $this->getJson('/api/news/guardian');

            // 5. Assert
            $response->assertStatus(200)
                    ->assertJsonStructure([
                        '*' => ['webTitle', 'webUrl'],
                    ]);
        }


        public function test_newsapi_endpoint_returns_articles(): void
        {
            config(['services.newsapi.api_key' => 'test-api-key']);

            Source::create([
                'name'    => 'NewsAPI',
                'slug'    => 'newsapi',
                'api_url' => 'https://newsapi.org/v2',
            ]);

            Http::fake([
                'https://newsapi.org/v2/everything*' => Http::response([
                    'articles' => [
                        [
                            'title' => 'Test Article',
                            'url'   => 'https://example.com',
                        ],
                    ],
                ], 200),
            ]);

            $response = $this->getJson('/api/news/newsapi');

            $response->assertStatus(200);
        }

    }
