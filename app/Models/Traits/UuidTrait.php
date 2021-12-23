<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait UuidTrait
{
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
}
