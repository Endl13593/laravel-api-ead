<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use App\Models\Support;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TokenTrait;

class SupportTest extends TestCase
{
    use TokenTrait;

    public function test_get_my_supports_unauthenticated()
    {
        $response = $this->getJson('/my-supports');

        $response->assertStatus(401);
    }

    public function test_get_my_supports()
    {
        $user = $this->createUser();
        $token = $user->createToken('test')->plainTextToken;

        Support::factory()->count(20)->create([ 'user_id' => $user->id ]);
        Support::factory()->count(20)->create();

        $response = $this->getJson('/my-supports', [ 'Authorization' => "Bearer {$token}" ]);

        $response->assertStatus(200)->assertJsonCount(20, 'data');
    }

    public function test_get_supports_unauthenticated()
    {
        $response = $this->getJson('/supports');

        $response->assertStatus(401);
    }

    public function test_get_supports()
    {
        Support::factory()->count(20)->create();

        $response = $this->getJson('/supports', $this->defaultHeaders());

        $response->assertStatus(200)->assertJsonCount(20, 'data');
    }

    public function test_get_supports_filter_lesson()
    {
        $lesson = Lesson::factory()->createOne();
        Support::factory()->count(20)->create();
        Support::factory()->count(5)->create([ 'lesson_id' => $lesson->id ]);

        $response = $this->json('GET',  '/supports', [ 'lesson' => $lesson->id ], $this->defaultHeaders());

        $response->assertStatus(200)->assertJsonCount(5, 'data');
    }

    public function test_create_support_unauthenticated()
    {
        $response = $this->postJson('/supports');

        $response->assertStatus(401);
    }

    public function test_create_support_errors_validations_empty()
    {
        $response = $this->postJson('/supports', [], $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_create_support_errors_validations_invalids()
    {
        $payload = [
            'lesson' => '99',
            'status' => 'X',
            'description' => ''
        ];

        $response = $this->postJson('/supports', $payload, $this->defaultHeaders());

        $jsonCompare = [
            "errors" => [
                "description" => [
                    "The description field is required."
                ],
                "lesson" => [
                    "The selected lesson is invalid."
                ],
                "status" => [
                    "The selected status is invalid."
                ]
            ],
            "message" => "The given data was invalid."
        ];

        $response->assertStatus(422)->assertExactJson($jsonCompare);
    }

    public function test_create_support()
    {
        $lesson = Lesson::factory()->createOne();
        $payload = [
            'lesson' => $lesson->id,
            'status' => 'P',
            'description' => 'Suporte de Teste'
        ];

        $response = $this->postJson('/supports', $payload, $this->defaultHeaders());

        $response->assertStatus(201);
    }
}
