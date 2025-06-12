<?php

namespace App\Infra;

use App\Domain\User\User;
use App\Domain\User\UserPersistenceInterface;
use Illuminate\Support\Facades\DB;

class UserDb implements UserPersistenceInterface
{
    public function loadUserByEmail(User $user): bool
    {
        $result = DB::table('users')
          ->where('email', $user->getEmail())
          ->first()
        ;

        if (!$user) {
            return false;
        }

        $user
            ->setId($result->id)
            ->setPassword($result->password)
            ->setRawAttributes((array) $result, true)
        ;

        return true;
    }
}