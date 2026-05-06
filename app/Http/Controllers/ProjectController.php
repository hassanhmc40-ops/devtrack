<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
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
        ]);

        Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('projects.index')->with('success', 'Projet mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
               $project = Project::findOrFail($id);
               $project->delete();
        return redirect()->route('projects.index')->with('success', 'Projet supprimé avec succès !');
    }
}
