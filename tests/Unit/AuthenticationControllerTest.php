<?php

declare(strict_types=1);

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistration()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->json('POST', '/auth/register', $data);
        $response->assertStatus(200);

    }

    public function testInvalidJson()
    {
        $response = $this->post('/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        $response->assertStatus(400);
    }

    public function testValidCredentialsLogin()
    {

        $this->seed();

        $response = $this->json('POST', '/auth/login', [
            'email' => 'customer@example.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);

    }

    public function testInvalidCredentialsLogin()
    {

        $response = $this->json('POST', '/auth/login', [
            'email' => 'customer@example.com',
            'password' => 'wrong'
        ]);

        $response->assertStatus(400);

    }

}
