<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriesEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_only_available_categories()
    {

        Category::factory()->create(['name' => 'Category', 'slug' => 'category']);      
        

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['name' => 'Category']);
    }
}
