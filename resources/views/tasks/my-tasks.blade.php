<x-app-layout>
    @section('title', 'My Tasks')
    @section('topbar-title', 'My Tasks')

    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px;font-weight:700;color:#111827;margin:0 0 4px;">My Tasks</h1>
        <p style="font-size:13.5px;color:#6b7280;margin:0;">Review and manage tasks assigned to you across all projects.</p>
    </div>

    @if ($tasks->isEmpty())
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:40px;text-align:center;">
            <h3 style="font-size:16px;font-weight:600;color:#374151;margin-bottom:8px;">No tasks assigned</h3>
            <p style="font-size:13.5px;color:#6b7280;margin:0;">You currently have no active tasks. Check your projects or ask your team lead for assignments.</p>
        </div>
    @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:18px;">
            @foreach ($tasks as $task)
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px;display:flex;flex-direction:column;gap:14px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
                        <div>
                            <h2 style="font-size:16px;font-weight:700;color:#111827;margin:0 0 6px;">{{ $task->title }}</h2>
                            <div style="font-size:12px;color:#6b7280;">
                                {{ strlen($task->description) > 120 ? substr($task->description, 0, 117)."..." : $task->description }}
                            </div>
                        </div>
                        <span style="font-size:11px;font-weight:600;text-transform:uppercase;color:#1d4ed8;background:#eff6ff;padding:6px 10px;border-radius:999px;">{{ str_replace('_', ' ', ucfirst($task->status)) }}</span>
                    </div>

                    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;font-size:13px;color:#6b7280;">
                        <div>Project: <strong style="color:#111827;">{{ $task->project->title }}</strong></div>
                        <div>Due: <strong style="color:#111827;">{{ optional($task->deadline)->format('M d, Y') ?? 'No deadline' }}</strong></div>
                    </div>

                    <a href="{{ route('projects.tasks.show', [$task->project, $task]) }}" class="btn-secondary" style="text-align:center;justify-content:center;">View Task</a>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
