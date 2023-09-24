<?php

declare(strict_types=1);

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestaurantControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testListRestaurants()
    {
        $response = $this->get('/restaurants');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'restaurants'
        ]);
    }

    public function testGetRestaurantDetails()
    {

        $this->seed();

        $response = $this->get('/restaurants/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'restaurant'
        ]);
    }

    public function testRestaurantNotFound()
    {
        $response = $this->get('/restaurants/1');

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'error'
        ]);
    }

}
