<x-app-layout>
    @section('title', 'Analytics')
    @section('topbar-title', 'Analytics')

    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px;font-weight:700;color:#111827;margin:0 0 4px;">Analytics</h1>
        <p style="font-size:13.5px;color:#6b7280;margin:0;">Track team progress, task distribution, and overdue work across your projects.</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px;">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px 20px;">
            <div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Total Tasks</div>
            <div style="font-size:32px;font-weight:800;color:#111827;">{{ $totalTasks }}</div>
            <div style="font-size:12px;color:#6b7280;margin-top:2px;">All tasks across your projects</div>
        </div>
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px 20px;">
            <div style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px;">Completed</div>
            <div style="font-size:32px;font-weight:800;color:#111827;">{{ $completedTasks }}</div>
            <div style="font-size:12px;color:#6b7280;margin-top:2px;">Tasks marked done</div>
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
        <h2 style="font-size:16px;font-weight:700;color:#111827;margin:0 0 14px;">Project Breakdown</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:14px;">
            @foreach ($projects as $project)
                @php
                    $projectTasks = $project->tasks->count();
                    $projectCompleted = $project->tasks->where('status', 'done')->count();
                    $projectProgress = $projectTasks > 0 ? round(($projectCompleted / $projectTasks) * 100) : 0;
                @endphp
                <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;padding:16px;">
                    <div style="font-size:14px;font-weight:700;color:#111827;margin-bottom:8px;">{{ $project->title }}</div>
                    <div style="font-size:12px;color:#6b7280;margin-bottom:10px;">{{ $projectTasks }} tasks · {{ $projectCompleted }} completed</div>
                    <div style="height:8px;background:#e5e7eb;border-radius:999px;overflow:hidden;margin-bottom:8px;">
                        <div style="width:{{ $projectProgress }}%;height:100%;background:#1d4ed8;transition:width .3s;"></div>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:12px;color:#6b7280;">
                        <span>{{ $projectProgress }}% done</span>
                        <a href="{{ route('projects.show', $project) }}" style="color:#2563eb;text-decoration:none;">View</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
