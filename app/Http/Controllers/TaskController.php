<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    /**
     * Display tasks for a project (US8)
     * Note: Tasks are shown in projects.show, so this might be optional
     */
    public function index(Project $project)
    {
        $this->authorize('view', $project);

        $tasks = $project->tasks()->with('assignedUser')->get();

        return view('tasks.index', compact('project', 'tasks'));
    }

    /**
     * Show the form for creating a new task (US9)
     */
    public function create(Project $project)
    {
        // Check if user is project lead
        $this->authorize('update', $project); // Only lead can create tasks

        // Get project members for assignment dropdown
        $members = $project->users;

        return view('tasks.create', compact('project', 'members'));
    }

    /**
     * Store a newly created task (US9)
     */
    public function store(StoreTaskRequest $request, Project $project)
    {
        $this->authorize('update', $project); // Only lead can create tasks

        // Verify assigned user is a project member
        if (!$project->users()->where('user_id', $request->assigned_to)->exists()) {
            return back()->withErrors(['assigned_to' => 'User must be a project member.']);
        }

        $task = $project->tasks()->create($request->validated());

        return redirect()->route('projects.show', $project)
            ->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified task
     */
    public function show(Project $project, Task $task)
    {
        $this->authorize('view', $task);

        $task->load(['project', 'assignedUser']);

        return view('tasks.show', compact('project', 'task'));
    }

    /**
     * Show the form for editing the task (US10)
     */
    public function edit(Project $project, Task $task)
    {
        $this->authorize('update', $task);

        $members = $project->users;

        return view('tasks.edit', compact('project', 'task', 'members'));
    }

    /**
     * Update the specified task (US10)
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $this->authorize('update', $task);

        // Verify assigned user is a project member
        if (!$project->users()->where('user_id', $request->assigned_to)->exists()) {
            return back()->withErrors(['assigned_to' => 'User must be a project member.']);
        }

        $task->update($request->validated());

        return redirect()->route('projects.show', $project)
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Update task status (US11 - Developer can only change status)
     */
    public function updateStatus(Request $request, Project $project, Task $task)
    {
        $this->authorize('changeStatus', $task);

        $request->validate([
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task->update(['status' => $request->status]);

        return back()->with('success', 'Task status updated successfully!');
    }

    /**
     * Remove the specified task (US12)
     */
    public function destroy(Project $project, Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('projects.show', $project)
            ->with('success', 'Task deleted successfully!');
    }
}