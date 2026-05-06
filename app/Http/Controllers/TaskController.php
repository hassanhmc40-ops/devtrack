<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with(['project', 'assignedUser'])->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.create', compact('projects', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,done',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'status' => $request->status,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tâche créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with(['project', 'assignedUser'])->findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::with(['project', 'assignedUser'])->findOrFail($id);
        $projects = Project::all();
        $users = User::all();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::with(['project', 'assignedUser'])->findOrFail($id);

        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:todo,in_progress,done',
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'priority' => $request->priority,
            'status' => $request->status,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tâche mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $task = Task::with(['project', 'assignedUser'])->findOrFail($id);
       $task->delete();
       return redirect()->route('tasks.index')->with('success', 'Tâche supprimée avec succès !');
    }
}
