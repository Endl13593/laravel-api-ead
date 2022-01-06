<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TokenTrait;

class LessonTest extends TestCase
{
    use TokenTrait;

    public function test_get_lessons_unauthenticated()
    {
        $response = $this->getJson('/modules/99/lessons');

        $response->assertStatus(401);
    }

    public function test_get_lessons_module_not_found()
    {
        $response = $this->getJson('/modules/99/lessons', $this->defaultHeaders());

        $response->assertStatus(200)->assertJsonCount(0, 'data');
    }

    public function test_get_lessons_module()
    {
        $module = Module::factory()->createOne();

        $response = $this->getJson("/modules/{$module->id}/lessons", $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_get_lessons_module_total()
    {
        $module = Module::factory()->createOne();
        Lesson::factory()->count(10)->create([ 'module_id' => $module->id ]);

        $response = $this->getJson("/modules/{$module->id}/lessons", $this->defaultHeaders());

        $response->assertStatus(200)->assertJsonCount(10, 'data');
    }

    public function test_get_single_lesson_unauthenticated()
    {
        $response = $this->getJson('/lessons/99');

        $response->assertStatus(401);
    }

    public function test_get_single_lesson_not_found()
    {
        $response = $this->getJson('/lessons/99', $this->defaultHeaders());

        $response->assertStatus(404);
    }

    public function test_get_single_lesson()
    {
        $lesson = Lesson::factory()->createOne();

        $response = $this->getJson("/lessons/{$lesson->id}", $this->defaultHeaders());

        $response->assertStatus(200);
    }
}
