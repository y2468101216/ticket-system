<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testLogin()
    {
        $response = $this->post('/api/login', [
            "name" => "rd",
            "password" => "123"
        ]);

        $response->assertStatus(200);
    }
}
