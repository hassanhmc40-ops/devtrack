<x-app-layout>
    @section('title', 'Dashboard')
    @section('topbar-title', 'Dashboard')

    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px;font-weight:700;color:#111827;margin:0 0 4px;">Dashboard</h1>
        <p style="font-size:13.5px;color:#6b7280;margin:0;">Quick overview of your active projects and task progress.</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px;">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px 20px;">
            <div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Total Projects</div>
            <div style="font-size:32px;font-weight:800;color:#111827;">{{ $projects->count() }}</div>
            <div style="font-size:12px;color:#6b7280;margin-top:2px;">Active projects you are assigned to</div>
        </div>
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px 20px;">
            <div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Total Tasks</div>
            <div style="font-size:32px;font-weight:800;color:#111827;">{{ $totalTasks }}</div>
            <div style="font-size:12px;color:#6b7280;margin-top:2px;">All tasks across your projects</div>
        </div>
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px 20px;">
            <div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">In Progress</div>
            <div style="font-size:32px;font-weight:800;color:#111827;">{{ $inProgressTasks }}</div>
            <div style="font-size:12px;color:#6b7280;margin-top:2px;">Tasks currently active</div>
        </div>
        <div style="background:#fff;border:1px solid #fca5a5;border-radius:12px;padding:18px 20px;">
            <div style="font-size:12px;font-weight:600;color:#dc2626;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Overdue</div>
            <div style="font-size:32px;font-weight:800;color:#dc2626;">{{ $overdueTasks }}</div>
            <div style="font-size:12px;color:#ef4444;margin-top:2px;">Needs attention</div>
        </div>
    </div>

    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;">
        <h2 style="font-size:16px;font-weight:700;color:#111827;margin:0 0 14px;">Active projects</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px;">
            @forelse ($projects as $project)
                <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;padding:16px;">
                    <div style="font-size:15px;font-weight:700;color:#111827;margin-bottom:8px;">{{ $project->title }}</div>
                    <div style="font-size:13px;color:#6b7280;margin-bottom:10px;">{{ Str::limit($project->description, 100) }}</div>
                    <a href="{{ route('projects.show', $project) }}" class="btn-secondary" style="display:inline-flex;align-items:center;justify-content:center;padding:10px 14px;">View Project</a>
                </div>
            @empty
                <div style="grid-column:1/-1;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:32px;text-align:center;">
                    <h3 style="font-size:16px;font-weight:600;color:#374151;margin-bottom:8px;">No active projects yet</h3>
                    <p style="font-size:13.5px;color:#6b7280;margin:0;">Create a new project or join a project to see activity here.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
