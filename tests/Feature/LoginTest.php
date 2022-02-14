<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/auth/login')
            ->assertStatus(422)
            ->assertJson([
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ]);
    }

    public function testUserLoginsSuccessfully()
    {
        $user = User::factory()->create(['password' => bcrypt('123456')]);
        $response = $this->json('POST', 'api/auth/login', ['email' => $user->email, 'password' => '123456']);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in'
        ]);
    }

    public function testUserAuthMe()
    {
        $user = User::factory()->create(['password' => bcrypt('123456')]);
        $response = $this->json('POST', 'api/auth/login', ['email' => $user->email, 'password' => '123456']);
        $token = json_decode($response->getContent())->access_token;
        $headers = ['Authorization' => "Bearer $token"];
        $response = $this->json('get', '/api/auth/me', [], $headers);
        $this->assertTrue(json_decode($response->getContent())->id == $user->id);
        $response->assertStatus(200);
    }
}
