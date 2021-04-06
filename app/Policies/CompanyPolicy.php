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
        Log::notice("Checking policy for user: " . $user);
        Log::notice("Checking policy for company: " . $company);
        return $company->createdBy()->get()->first()->id === $user->id;
    }
}
