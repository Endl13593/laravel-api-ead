<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository
{
    protected Course $entity;

    public function __construct(Course $model)
    {
        $this->entity = $model;
    }

    public function getAllCourses()
    {
        return $this->entity->all();
    }

    public function getCourse(string $identify)
    {
        return $this->entity->findOrFail($identify);
    }
}