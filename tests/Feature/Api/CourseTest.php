<?php

namespace Tests\Feature\Api;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\TokenTrait;

class CourseTest extends TestCase
{
    use TokenTrait;

    public function test_get_courses_unauthenticated()
    {
        $response = $this->getJson('/courses');

        $response->assertStatus(401);
    }

    public function test_get_courses()
    {
        $response = $this->getJson('/courses', $this->defaultHeaders());

        $response->assertStatus(200);
    }

    public function test_get_courses_total()
    {
        Course::factory()->count(10)->create();

        $response = $this->getJson('/courses', $this->defaultHeaders());

        $response->assertStatus(200)->assertJsonCount(10, 'data');
    }

    public function test_get_single_course_unauthenticated()
    {
        $response = $this->getJson('/courses/99');

        $response->assertStatus(401);
    }

    public function test_get_single_course_not_found()
    {
        $response = $this->getJson('/courses/99', $this->defaultHeaders());

        $response->assertStatus(404);
    }

    public function test_get_single_course()
    {
        $course = Course::factory()->createOne();

        $response = $this->getJson("/courses/{$course->id}", $this->defaultHeaders());

        $response->assertStatus(200);
    }
}
