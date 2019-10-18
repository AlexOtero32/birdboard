<?php

namespace App\Policies;

use App\User;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ProjectPolicy
 *
 * @package App\Policies
 */
class ProjectPolicy {
    use HandlesAuthorization;

    /**
     * @param \App\User $user
     * @param \App\Project $project
     *
     * @return bool
     */
    public function update(User $user, Project $project) {
        return $user->is($project->owner) || $project->members->contains($user);
    }
}
