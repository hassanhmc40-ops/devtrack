<x-app-layout>
    @section('title', $task->title)
    @section('topbar-title')
        <div class="breadcrumb">
            <a href="{{ route('projects.index') }}">PROJECTS</a>
            <span class="breadcrumb-sep">›</span>
            <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
            <span class="breadcrumb-sep">›</span>
            <span style="color:#111827;font-weight:600;">Task Detail</span>
        </div>
    @endsection

    @section('topbar-actions')
        @can('update', $task)
            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="btn-secondary" style="font-size:12.5px;padding:6px 12px;" id="edit-task-btn">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Task
            </a>
        @endcan
    @endsection

    @php
        $priorityMap = [
            'high'   => ['bg'=>'#fee2e2','text'=>'#dc2626','label'=>'HIGH'],
            'medium' => ['bg'=>'#fef3c7','text'=>'#d97706','label'=>'MEDIUM'],
            'low'    => ['bg'=>'#dcfce7','text'=>'#15803d','label'=>'LOW'],
        ];
        $pc = $priorityMap[$task->priority] ?? $priorityMap['medium'];

        $statusMap = [
            'todo'        => ['bg'=>'#f3f4f6','text'=>'#374151','label'=>'To Do'],
            'in_progress' => ['bg'=>'#dbeafe','text'=>'#1d4ed8','label'=>'In Progress'],
            'done'        => ['bg'=>'#dcfce7','text'=>'#15803d','label'=>'Completed'],
        ];
        $sc = $statusMap[$task->status] ?? $statusMap['todo'];

        $isOverdue = $task->deadline && $task->deadline->isPast() && $task->status !== 'done';
    @endphp

    <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">

        {{-- Left: Task Detail --}}
        <div>
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:28px;margin-bottom:16px;">

                {{-- Badges --}}
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:14px;flex-wrap:wrap;">
                    <span style="background:{{ $pc['bg'] }};color:{{ $pc['text'] }};font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;letter-spacing:.3px;">{{ $pc['label'] }}</span>
                    <span style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }};font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">{{ $sc['label'] }}</span>
                    @if ($isOverdue)
                        <span style="background:#fee2e2;color:#dc2626;font-size:11px;font-weight:700;padding:3px 10px;border-radius:20px;">OVERDUE</span>
                    @endif
                </div>

                {{-- Title --}}
                <h1 style="font-size:20px;font-weight:700;color:#111827;margin:0 0 12px;line-height:1.3;">{{ $task->title }}</h1>

                {{-- Description --}}
                @if ($task->description)
                    <div style="font-size:14px;color:#374151;line-height:1.7;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #f3f4f6;">
                        {{ $task->description }}
                    </div>
                @else
                    <div style="font-size:13.5px;color:#9ca3af;font-style:italic;margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid #f3f4f6;">
                        No description provided.
                    </div>
                @endif

                {{-- Meta grid --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                    <div>
                        <div style="font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px;">Assigned To</div>
                        @if ($task->assignedUser)
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;">{{ strtoupper(substr($task->assignedUser->name, 0, 1)) }}</div>
                                <div>
                                    <div style="font-size:13.5px;font-weight:600;color:#111827;">{{ $task->assignedUser->name }}</div>
                                    <div style="font-size:11.5px;color:#6b7280;">{{ $task->assignedUser->email }}</div>
                                </div>
                            </div>
                        @else
                            <span style="font-size:13.5px;color:#9ca3af;">Unassigned</span>
                        @endif
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px;">Project</div>
                        <a href="{{ route('projects.show', $project) }}" style="font-size:13.5px;font-weight:600;color:#1d4ed8;text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">{{ $project->title }}</a>
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px;">Deadline</div>
                        @if ($task->deadline)
                            <div style="display:flex;align-items:center;gap:5px;font-size:13.5px;font-weight:600;color:{{ $isOverdue ? '#dc2626' : '#111827' }};">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $task->deadline->format('M d, Y') }}
                                @if ($isOverdue) <span style="font-size:11px;color:#dc2626;">(Overdue)</span> @endif
                            </div>
                        @else
                            <span style="font-size:13.5px;color:#9ca3af;">No deadline</span>
                        @endif
                    </div>
                    <div>
                        <div style="font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px;">Created</div>
                        <div style="font-size:13.5px;color:#111827;">{{ $task->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;">
                <div style="font-size:13px;font-weight:600;color:#374151;margin-bottom:12px;">Quick Actions</div>
                <div style="display:flex;gap:10px;flex-wrap:wrap;">
                    @can('changeStatus', $task)
                        <form method="POST" action="{{ route('tasks.status', [$project, $task]) }}" style="display:flex;align-items:center;gap:8px;">
                            @csrf @method('PATCH')
                            <select name="status" class="form-input" style="padding:8px 12px;font-size:13px;min-width:160px;" onchange="this.form.submit()" id="quick-status-select">
                                <option value="todo"        {{ $task->status === 'todo'        ? 'selected' : '' }}>📋 To Do</option>
                                <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>🔵 In Progress</option>
                                <option value="done"        {{ $task->status === 'done'        ? 'selected' : '' }}>✅ Done</option>
                            </select>
                        </form>
                    @endcan

                    @can('update', $task)
                        <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="btn-secondary" style="font-size:13px;">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </a>
                    @endcan

                    @can('delete', $task)
                        <form method="POST" action="{{ route('projects.tasks.destroy', [$project, $task]) }}"
                            onsubmit="return confirm('Delete this task?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger" style="font-size:13px;" id="delete-task-detail-btn">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                                Delete
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>

        {{-- Right: Activity / Related --}}
        <div>
            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;margin-bottom:14px;">
                <div style="font-size:13px;font-weight:700;color:#111827;margin-bottom:14px;padding-bottom:10px;border-bottom:1px solid #f3f4f6;">Task Details</div>

                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:12.5px;color:#6b7280;">Status</span>
                        <span style="background:{{ $sc['bg'] }};color:{{ $sc['text'] }};font-size:11.5px;font-weight:600;padding:2px 10px;border-radius:20px;">{{ $sc['label'] }}</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:12.5px;color:#6b7280;">Priority</span>
                        <span style="background:{{ $pc['bg'] }};color:{{ $pc['text'] }};font-size:11.5px;font-weight:600;padding:2px 10px;border-radius:20px;">{{ ucfirst($task->priority) }}</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:12.5px;color:#6b7280;">Urgency</span>
                        <span style="font-size:12.5px;font-weight:600;color:{{ $task->deadline_status === 'Urgent' ? '#dc2626' : ($task->deadline_status === 'Soon' ? '#d97706' : '#15803d') }};">{{ $task->deadline_status }}</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:12.5px;color:#6b7280;">Last Updated</span>
                        <span style="font-size:12.5px;color:#374151;">{{ $task->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            {{-- Back button --}}
            <a href="{{ route('projects.show', $project) }}" class="btn-secondary" style="width:100%;justify-content:center;font-size:13px;" id="back-to-project-btn">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Back to {{ $project->title }}
            </a>
        </div>
    </div>
</x-app-layout>
