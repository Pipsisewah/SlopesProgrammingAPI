<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserDataPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, UserData $userData): bool{
        return $this->isCurrentUserData($user, $userData);
    }

    public function edit(User $user, UserData $userData): bool{
        return $this->isCurrentUserData($user, $userData);
    }

    private function isCurrentUserData(User $user, UserData $userData): bool{
        return $userData->user()->first()->id === $user->id;
    }
}
