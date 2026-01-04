<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article;
use App\Models\Source;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticlesApiTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_it_returns_paginated_articles():void
    {
        $source = Source::factory()->create([
            'slug' => 'guardian',
        ]);

        $category = Category::factory()->create([
            'slug' => 'technology',
        ]);

        Article::factory()->count(3)->create([
            'source_id' => $source->id,
            'category_id' => $category->id,
        ]);

        $response = $this->getJson('/api/articles');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);

        $this->assertCount(3, $response->json('data'));
    }

  
    public function test_it_can_filter_articles_by_source():void
    {
        $guardian = Source::factory()->create(['slug' => 'guardian']);
        $newsapi  = Source::factory()->create(['slug' => 'newsapi']);

        Article::factory()->create(['source_id' => $guardian->id]);
        Article::factory()->create(['source_id' => $newsapi->id]);

        $response = $this->getJson('/api/articles?source=guardian');

        $response->assertStatus(200);

        $articles = $response->json('data');

        $this->assertCount(1, $articles);
        $this->assertEquals('guardian', $articles[0]['source']);
    }
}
