<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Add a member to the project (US7)
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('addMember', $project);

        // Validate email
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if user is already a member
        if ($project->users()->where('user_id', $user->id)->exists()) {
            return back()->withErrors(['email' => 'User is already a member of this project.']);
        }

        // Attach user as developer
        $project->users()->attach($user->id, ['role' => 'developer']);

        return back()->with('success', 'Developer added successfully!');
    }

    /**
     * Remove a member from the project (US7)
     */
    public function destroy(Project $project, User $user)
    {
        $this->authorize('removeMember', $project);

        // Prevent removing the lead
        $membership = $project->users()->where('user_id', $user->id)->first();

        if (!$membership) {
            return back()->withErrors(['error' => 'User is not a member of this project.']);
        }

        if ($membership->pivot->role === 'lead') {
            return back()->withErrors(['error' => 'Cannot remove the project lead.']);
        }

        // Detach user
        $project->users()->detach($user->id);

        return back()->with('success', 'Member removed successfully!');
    }
}