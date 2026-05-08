<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine if the user can view the task.
     * Rule: User must be a member of the task's project
     */
    public function view(User $user, Task $task): bool
    {
        return $task->project->users()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine if the user can create tasks.
     * Rule: Only the project lead can create tasks
     * Note: We need the project context, so we check in the controller
     */
    public function create(User $user, Task $task): bool
    {
        // Task doesn't exist yet, so we check project membership in controller
        // This method is for tasks that already exist
        return $task->project->users()
                             ->where('user_id', $user->id)
                             ->wherePivot('role', 'lead')
                             ->exists();
    }

    /**
     * Determine if the user can update the task.
     * Rule: Only the project lead can update task details
     */
    public function update(User $user, Task $task): bool
    {
        return $task->project->users()
                             ->where('user_id', $user->id)
                             ->wherePivot('role', 'lead')
                             ->exists();
    }

    /**
     * Determine if the user can delete the task.
     * Rule: Only the project lead can delete tasks
     */
    public function delete(User $user, Task $task): bool
    {
        return $task->project->users()
                             ->where('user_id', $user->id)
                             ->wherePivot('role', 'lead')
                             ->exists();
    }

    /**
     * Determine if the user can change the task status.
     * Rule: Only the assigned developer (or lead) can change status
     */
    public function changeStatus(User $user, Task $task): bool
    {
        // User must be the assigned developer
        if ($task->assigned_to === $user->id) {
            return true;
        }

        // OR user must be the project lead
        return $task->project->users()
                             ->where('user_id', $user->id)
                             ->wherePivot('role', 'lead')
                             ->exists();
    }
}
