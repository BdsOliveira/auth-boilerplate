<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }
    /**
     * A basic feature test example.
     */
    public function test_login(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'test@example.com',
            'password' => '12345678',
            'device_name' => 'phpunit',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_login_with_user_that_is_not_registered(): void
    {
        $response = $this->post('/api/login', [
            'email' => 'not_user@example.com',
            'password' => '12345678',
            'device_name' => 'phpunit',
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_login_without_user_email_or_password_or_device_name(): void
    {
        $response = $this->post('/api/login', [
            'anything_else' => 'value',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
