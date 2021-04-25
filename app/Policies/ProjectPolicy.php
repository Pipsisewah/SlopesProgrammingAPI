<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class ProjectPolicy
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

    /**
     * @param User $user
     * @param Project $project
     *
     * @return bool
     */
    public function create(User $user, Project $project): bool{
        Log::notice("Checking to see if user can create a project");
        return true;
    }

    /**
     * @param User $user
     * @param Project $project
     *
     * @return bool
     */
    public function edit(User $user, Project $project): bool{
        return $this->isUserCreatorOfProject($user, $project);
    }

    /**
     * @param User $user
     * @param Project $project
     *
     * @return bool
     */
    public function delete(User $user, Project $project): bool{
        return $this->isUserCreatorOfProject($user, $project);
    }

    /**
     * @param User $user
     * @param Project $project
     *
     * @return bool
     */
    private function isUserCreatorOfProject(User $user, Project $project): bool{
        return $project->createdBy()->get()->first()->id === $user->id;
    }
}
