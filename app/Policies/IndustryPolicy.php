<?php

namespace App\Policies;

use App\Models\Industry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IndustryPolicy
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

    public function view(User $user, Industry $industry): bool
    {
        return true;
    }

    public function update(User $user, Industry $industry): bool{
        return false;
    }

    public function delete(User $user, Industry $industry): bool{
        return false;
    }
}
