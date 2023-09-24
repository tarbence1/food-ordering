<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateOrder()
    {

        $this->seed();

        auth()->login(User::find(1));

        $response = $this->json('POST', '/orders', [
            'customerId' => 1,
            'restaurantId' => 1,
            'items' => [
                [
                    'menuId' => 1,
                    'quantity' => 10,
                    'instructions' => 'No onions'
                ]
            ]
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id'
        ]);
    }


}
