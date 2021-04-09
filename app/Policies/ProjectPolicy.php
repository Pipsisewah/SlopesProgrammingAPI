<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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
