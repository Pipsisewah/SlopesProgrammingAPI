<?php

namespace App\Policies;

use App\Models\Feature;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class FeaturePolicy
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

    public function delete(User $user, Feature $feature): bool{
        return $this->isUserOwnerOfFeature($user, $feature);
    }

    private function isUserOwnerOfFeature(User $user, Feature $feature): bool{
        Log::notice("Feature User ID: " . $feature->user()->first()->id);
        Log::notice("User ID: " . $user->id);
        return $feature->user()->first()->id === $user->id;
    }
}
