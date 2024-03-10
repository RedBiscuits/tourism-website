<?php

namespace Tests\Feature;

use App\Models\Tour;
use Tests\TestCase;

class TourControllerTest extends TestCase
{
    /** @test */
    public function it_returns_paginated_tours()
    {
        // Create sample tours
        Tour::factory()->count(10)->create();

        // Mock the request with dummy data
        $requestData = [
            'name' => 'search_name',
            'description' => 'search_description',
            'location' => 'search_location',
            'duration' => 'search_duration',
        ];

        // Make a GET request to the endpoint
        $response = $this->get('/api/tours/all', $requestData);

        // Assert that the response is successful
        $response->assertOk();

        // Assert that the response data matches the expected structure
        $response->assertJsonStructure([
            'message',
            'data',
        ]);
    }
}
