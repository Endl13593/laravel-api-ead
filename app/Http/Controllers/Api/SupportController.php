<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupportFormRequest;
use App\Http\Resources\SupportResource;
use App\Repositories\SupportRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SupportController extends Controller
{
    protected SupportRepository $repository;

    public function __construct(SupportRepository $supportRepository)
    {
        $this->repository = $supportRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $supports = $this->repository->getSupports($request->all());

        return SupportResource::collection($supports);
    }

    public function store(StoreSupportFormRequest $request): SupportResource
    {
        $support = $this->repository->createNewSupport($request->validated());

        return new SupportResource($support);
    }

    public function mySupports(Request $request): AnonymousResourceCollection
    {
        $supports = $this->repository->getMySupports($request->all());

        return SupportResource::collection($supports);
    }
}
