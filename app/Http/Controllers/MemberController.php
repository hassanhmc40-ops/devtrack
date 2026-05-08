<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a list of team members across the user's projects.
     */
    public function index()
    {
        $projects = auth()->user()->projects()->with('users')->get();

        $members = $projects->flatMap(function ($project) {
            return $project->users;
        })->unique('id')->values();

        return view('team-members.index', compact('members'));
    }

    /**
     * Add a member to the project (US7)
     * Only the project lead can add members.
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project); // Only lead can add members

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
     * Only the project lead can remove members (cannot remove lead).
     */
    public function destroy(Project $project, User $user)
    {
        $this->authorize('update', $project); // Only lead can remove members

        $membership = $project->users()->where('user_id', $user->id)->first();

        if (!$membership) {
            return back()->withErrors(['error' => 'User is not a member of this project.']);
        }

        // Prevent removing the lead
        if ($membership->pivot->role === 'lead') {
            return back()->withErrors(['error' => 'Cannot remove the project lead.']);
        }

        $project->users()->detach($user->id);

        return back()->with('success', 'Member removed successfully!');
    }
}
