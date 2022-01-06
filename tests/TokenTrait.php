<?php

namespace Tests;

use App\Models\User;

trait TokenTrait
{
    private function createUser(): User
    {
        return User::factory()->createOne();
    }

    private function getTokenUserAuth()
    {
        $user = $this->createUser();
    
        return $user->createToken('test')->plainTextToken;
    }

    private function defaultHeaders()
    {
        return [
            'Authorization' => "Bearer {$this->getTokenUserAuth()}"
        ];
    }
}