<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TokenTrait;

class ViewTest extends TestCase
{
    use TokenTrait;

    public function test_make_viewed_unauthenticated()
    {
        $response = $this->postJson('/lessons/viewed');

        $response->assertStatus(401);
    }

    public function test_make_viewed_errors_validations()
    {
        $response = $this->postJson('/lessons/viewed', [], $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_make_viewed_invalid_lesson()
    {
        $response = $this->postJson('/lessons/viewed', [ 'lesson' => '99' ], $this->defaultHeaders());

        $response->assertStatus(422);
    }

    public function test_make_viewed()
    {
        $lesson = Lesson::factory()->createOne();

        $response = $this->postJson('/lessons/viewed', [ 'lesson' => $lesson->id ], $this->defaultHeaders());

        $response->assertStatus(200);
    }
}
