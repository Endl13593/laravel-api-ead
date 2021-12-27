<?php

namespace App\Repositories;

use App\Models\Support;

class SupportRepository
{
    protected Support $entity;

    public function __construct(Support $model)
    {
        $this->entity = $model;
    }

    public function getSupports(array $filters = [])
    {
        return $this->entity->where('user_id', '=', 'abc')->get();
    }
}
