<?php

namespace App\Policies;

use App\Models\Education;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EducationPolicy
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

    public function view(User $user, Education $company): bool
    {
        return true;
    }

    public function update(User $user, Education $company): bool{
        return false;
    }

    public function delete(User $user, Education $company): bool{
        return false;
    }
}
