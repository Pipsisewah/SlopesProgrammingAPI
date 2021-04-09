<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class CompanyPolicy
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

    public function view(User $user, Company $company): bool
    {
        return true;
    }

    public function update(User $user, Company $company): bool{
        return $this->isUserCreatorOfCompany($user, $company);
    }

    public function delete(User $user, Company $company): bool{
        return $this->isUserCreatorOfCompany($user, $company);
    }

    private function isUserCreatorOfCompany(User $user, Company $company): bool{
        return $company->createdBy()->get()->first()->id === $user->id;
    }
}
