<?php

namespace App\Repositories;

use App\Models\Lesson;
use App\Repositories\Traits\RepositoryTrait;

class LessonRepository
{
    use RepositoryTrait;

    protected Lesson $entity;

    public function __construct(Lesson $model)
    {
        $this->entity = $model;
    }

    public function getLessonsByModuleId(string $moduleId)
    {
        return $this->entity->with(['supports.replies', 'views'])->where('module_id', '=', $moduleId)->get();
    }

    public function getLesson(string $identify)
    {
        return $this->entity->with(['supports.replies', 'views'])->findOrFail($identify);
    }

    public function markLessonViewed(string $lessonId)
    {
        $user = $this->getUserAuth();

        $view = $user->views()->where('lesson_id', $lessonId)->first();

        if ($view) {
            return $view->update([
                'qty' => $view->qty + 1
            ]);
        }

        return $user->views()->create([
            'lesson_id' => $lessonId
        ]);
    }
}
