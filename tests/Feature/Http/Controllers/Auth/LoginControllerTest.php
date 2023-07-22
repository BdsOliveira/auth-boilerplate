<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_without_email(): void
    {
        $response = $this->post('/api/login', [
            'password' => '12345678',
        ]);

        $response->assertStatus(200);
    }
}
