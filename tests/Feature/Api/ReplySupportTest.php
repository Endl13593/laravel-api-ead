<?php

namespace Tests\Feature\Api;

use App\Models\Support;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TokenTrait;

class ReplySupportTest extends TestCase
{
    use TokenTrait;

    public function test_create_reply_to_support_unauthenticated()
    {
        $response = $this->postJson('/replies');

        $response->assertStatus(401);
    }

    public function test_create_reply_to_support_erros_validations_empty()
    {
        $response = $this->postJson('/replies', [], $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_create_reply_to_support_erros_validations_invalids()
    {
        $payload = [
            'support' => '99',
            'description' => ''
        ];

        $response = $this->postJson('/replies', $payload, $this->defaultHeaders());

        $jsonCompare = [
            "message" => "The given data was invalid.",
            "errors" => [
                "support" => [
                    "The selected support is invalid."
                ],
                "description" => [
                    "The description field is required."
                ]
            ]
        ];

        $response->assertStatus(422)->assertExactJson($jsonCompare);
    }

    public function test_create_reply_to_support()
    {
        $support = Support::factory()->createOne();

        $payload = [
            'support' => $support->id,
            'description' => 'Descrição de Teste'
        ];

        $response = $this->postJson('/replies', $payload, $this->defaultHeaders());

        $response->assertStatus(201);
    }
}
