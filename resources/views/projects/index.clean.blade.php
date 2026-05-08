<x-app-layout>
    @section('title', 'All Projects')
    @section('topbar-title', 'All Projects')

    @section('topbar-actions')
        @can('create', App\Models\Project::class)
            <a href="{{ route('projects.create') }}" class="btn-primary">Create Project</a>
        @endcan
    @endsection

    <div style="margin-bottom:24px;">
        <h1>All Projects</h1>
        <p>Browse and manage your assigned projects.</p>
    </div>

    @if ($projects->isEmpty())
        <div>
            <h3>No projects yet</h3>
            <p>You haven't been added to any projects yet.</p>
            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}" class="btn-primary">Create your first project</a>
            @endcan
        </div>
    @else
        <div>
            @foreach ($projects as $project)
                <div>
                    <h2><a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a></h2>
                    <p>{{ Str::limit($project->description, 75) }}</p>
                    <p>{{ $project->tasks_count ?? 0 }} tasks</p>
                    <a href="{{ route('projects.show', $project) }}">View Project</a>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
