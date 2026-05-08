<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine if the user can view the project.
     * Rule: User must be a member (lead or developer) of the project
     */
    public function view(User $user, Project $project): bool
    {
        return $project->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine if the user can create projects.
     * Rule: Any authenticated user can create a project (they become lead automatically)
     */
    public function create(User $user): bool
    {
        return true; // All logged-in users can create projects
    }

    /**
     * Determine if the user can update the project.
     * Rule: Only the project lead can update
     */
    public function update(User $user, Project $project): bool
    {
        return $project->users()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }

    /**
     * Determine if the user can delete (archive) the project.
     * Rule: Only the project lead can archive
     */
    public function delete(User $user, Project $project): bool
    {
        return $project->users()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }

    /**
     * Determine if the user can restore the project.
     * Rule: Only the project lead can restore
     */
    public function restore(User $user, Project $project): bool
    {
        return $project->users()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }

    /**
     * Determine if the user can permanently delete the project.
     * Rule: Only the project lead can force delete
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return $project->users()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }

    /**
     * Determine if the user can add members to the project.
     * Rule: Only the project lead can add members
     */
    public function addMember(User $user, Project $project): bool
    {
        return $project->users()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }

    /**
     * Determine if the user can remove members from the project.
     * Rule: Only the project lead can remove members
     */
    public function removeMember(User $user, Project $project): bool
    {
        return $project->users()
                       ->where('user_id', $user->id)
                       ->wherePivot('role', 'lead')
                       ->exists();
    }
}