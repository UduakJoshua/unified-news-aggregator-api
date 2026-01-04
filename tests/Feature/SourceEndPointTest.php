<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Source;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SourceEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_only_active_sources()
    {
        
        Source::factory()->create(['name' => 'Active Source', 'active' => true]);
        Source::factory()->create(['name' => 'Inactive Source', 'active' => false]);
        
        $response = $this->getJson('/api/sources');
       
        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['name' => 'Active Source'])
                 ->assertJsonMissing(['name' => 'Inactive Source']);
    }
}
