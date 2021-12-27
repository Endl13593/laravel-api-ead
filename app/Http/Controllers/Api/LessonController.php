<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Repositories\LessonRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LessonController extends Controller
{
    protected LessonRepository $repository;

    public function __construct(LessonRepository $moduleRepository)
    {
        $this->repository = $moduleRepository;
    }

    public function index($moduleId): AnonymousResourceCollection
    {
        $lessons = $this->repository->getLessonsByModuleId($moduleId);

        return LessonResource::collection($lessons);
    }

    public function show($id): LessonResource
    {
        $lesson = $this->repository->getLesson($id);

        return new LessonResource($lesson);
    }
}
