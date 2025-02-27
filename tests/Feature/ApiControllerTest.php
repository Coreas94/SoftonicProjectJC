<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    public function test_api_returns_correct_data()
    {
        $response = $this->getJson('/api/apps/21824');

        $response->assertStatus(200)
         ->assertJsonStructure([
            'success',
            'data' => [
                  'id',
                  'author_info' => ['name', 'url'],
                  'title',
                  'version',
                  'url',
                  'short_description',
                  'license',
                  'thumbnail',
                  'rating',
                  'total_downloads',
                  'compatible',
            ],
         ])
         ->assertJsonFragment(['id' => "21824", 'title' => "Ares"]);
    }

    public function test_api_returns_404_for_invalid_id()
    {
        $response = $this->getJson('/api/apps/999999');

        $response->assertStatus(404)
         ->assertJson([
            'success' => false,
            'error' => 'App not found',
         ]);
    }
}
