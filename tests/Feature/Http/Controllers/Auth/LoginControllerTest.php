<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Http\Response;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    protected $errorsDefinition = [
        'message',
        'errors' => [],
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }
    /**
     * A basic feature test example.
     */
    public function test_login_with_valid_credentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => '12345678',
            'device_name' => 'phpunit',
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'message',
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                ],
            ]);
    }

    public function test_login_with_user_that_is_not_registered(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'not_user@example.com',
            'password' => '12345678',
            'device_name' => 'phpunit',
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertJsonStructure($this->errorsDefinition);
    }

    public function test_login_without_email_and_password_and_device_name(): void
    {
        $response = $this->postJson('/api/login', [
            'anything_else' => 'value',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure($this->errorsDefinition)
            ->assertJsonValidationErrors([
                'email',
                'password',
                'device_name',
            ]);
    }

    public function test_login_without_email(): void
    {
        $response = $this->postJson('/api/login', [
            'password' => '12345678',
            'device_name' => 'phpunit',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure($this->errorsDefinition)
            ->assertJsonValidationErrors([
                'email',
            ]);
    }

    public function test_login_without_password(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'device_name' => 'phpunit',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure($this->errorsDefinition)
            ->assertJsonValidationErrors([
                'password',
            ]);
    }

    public function test_login_without_device_name(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => '12345678',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure($this->errorsDefinition)
            ->assertJsonValidationErrors([
                'device_name',
            ]);
    }
}
