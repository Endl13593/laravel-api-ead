<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TokenTrait;

class AuthTest extends TestCase
{
    use TokenTrait;
    
    public function test_fail_auth()
    {
        $response = $this->postJson('/auth', []);

        $response->assertStatus(422);
    }

    public function test_auth()
    {
        $user = User::factory()->createOne();

        $response = $this->postJson('/auth', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'test'
        ]);

        $response->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function test_fail_logout()
    {
        $response = $this->getJson('/logout');

        $response->assertStatus(401);
    }

    public function test_logout()
    {
        $response = $this->getJson('/logout', $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_fail_get_me()
    {
        $response = $this->getJson('/me');

        $response->assertStatus(401);
    }

    public function test_get_me()
    {
        $response = $this->getJson('/me', $this->defaultHeaders());

        $response->assertStatus(200);
    }
}
