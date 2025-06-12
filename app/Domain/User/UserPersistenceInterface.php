<?php

namespace App\Domain\User;

interface UserPersistenceInterface
{
    public function loadUserByEmail(User $user): bool;
}
