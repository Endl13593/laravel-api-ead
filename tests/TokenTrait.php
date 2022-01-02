<?php

namespace Tests;

use App\Models\User;

trait TokenTrait
{
    private function getTokenUserAuth()
    {
        $user = User::factory()->createOne();
    
        return $user->createToken('test')->plainTextToken;
    }
}