<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    public function testGetEmployee()
    {
        $this->seed();
        $response = $this->json('POST', 'api/auth/login', ['email' => 'test@admin.com', 'password' => '123456']);
        $token = json_decode($response->getContent())->access_token;
        $headers = ['Authorization' => "Bearer $token"];
        $response = $this->json('get', '/api/employee/1', [], $headers);
        $response->assertStatus(200);
    }
}
