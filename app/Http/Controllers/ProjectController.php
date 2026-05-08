<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the user's projects (Dashboard - US2)
     */
    public function index()
    {
        // Get only projects where user is a member
        $projects = auth()->user()->projects()
            ->withCount([
                'tasks',
                'tasks as completed_tasks_count' => function ($query) {
                    $query->where('status', 'done');
                }
            ])
            ->get();

        return view('projects.index', compact('projects'));
    }

    /**
     * Display the main dashboard with summary metrics.
     */
    public function dashboard()
    {
        $projects = auth()->user()->projects()->with('tasks')->get();

        $totalTasks = $projects->sum(function ($project) {
            return $project->tasks->count();
        });
        $completedTasks = $projects->sum(function ($project) {
            return $project->tasks->where('status', 'done')->count();
        });
        $todoTasks = $projects->sum(function ($project) {
            return $project->tasks->where('status', 'todo')->count();
        });
        $inProgressTasks = $projects->sum(function ($project) {
            return $project->tasks->where('status', 'in_progress')->count();
        });
        $overdueTasks = $projects->sum(function ($project) {
            return $project->tasks->filter(function ($task) {
                return $task->deadline && $task->deadline->isPast() && $task->status !== 'done';
            })->count();
        });

        return view('dashboard', compact('projects', 'totalTasks', 'completedTasks', 'todoTasks', 'inProgressTasks', 'overdueTasks'));
    }

    /**
     * Display analytics for the authenticated user's projects.
     */
    public function analytics()
    {
        $projects = auth()->user()->projects()->with('tasks')->get();

        $totalTasks = $projects->sum(function ($project) {
            return $project->tasks->count();
        });
        $completedTasks = $projects->sum(function ($project) {
            return $project->tasks->where('status', 'done')->count();
        });
        $todoTasks = $projects->sum(function ($project) {
            return $project->tasks->where('status', 'todo')->count();
        });
        $inProgressTasks = $projects->sum(function ($project) {
            return $project->tasks->where('status', 'in_progress')->count();
        });
        $overdueTasks = $projects->sum(function ($project) {
            return $project->tasks->filter(function ($task) {
                return $task->deadline && $task->deadline->isPast() && $task->status !== 'done';
            })->count();
        });

        return view('analytics.index', compact('projects', 'totalTasks', 'completedTasks', 'todoTasks', 'inProgressTasks', 'overdueTasks'));
    }

    /**
     * Show the form for creating a new project (US3)
     */
    public function create()
    {
        $this->authorize('create', Project::class);

        return view('projects.create');
    }

    /**
     * Store a newly created project (US3)
     */
    public function store(StoreProjectRequest $request)
    {
        $this->authorize('create', Project::class);

        // Create project
        $project = Project::create($request->validated());

        // Attach creator as lead
        $project->users()->attach(auth()->id(), ['role' => 'lead']);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified project (US8 - shows tasks)
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        // Eager load relationships to prevent N+1
        $project->load(['users', 'tasks.assignedUser']);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the project (US4)
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project (US4)
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($request->validated());

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully!');
    }

    /**
     * Archive (soft delete) the project (US5)
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete(); // Soft delete

        return redirect()->route('projects.index')
            ->with('success', 'Project archived successfully!');
    }

    /**
     * Show archived projects (US5)
     */
    public function archives()
    {
        $archivedProjects = auth()->user()->projects()
            ->onlyTrashed()
            ->withCount('tasks')
            ->get();

        return view('projects.archives', compact('archivedProjects'));
    }

    /**
     * Restore an archived project (US6)
     */
    public function restore($id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $project);

        $project->restore();

        return redirect()->route('projects.index')
            ->with('success', 'Project restored successfully!');
    }

    /**
     * Permanently delete a project (Bonus)
     */
    public function forceDelete($id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $project);

        $project->forceDelete();

        return redirect()->route('projects.archives')
            ->with('success', 'Project permanently deleted!');
    }
}
