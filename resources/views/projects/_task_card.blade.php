@php
    $priorityColors = [
        'high'   => ['bg' => '#fee2e2', 'text' => '#dc2626', 'label' => 'HIGH'],
        'medium' => ['bg' => '#fef3c7', 'text' => '#d97706', 'label' => 'MEDIUM'],
        'low'    => ['bg' => '#dcfce7', 'text' => '#15803d', 'label' => 'LOW'],
    ];
    $pc = $priorityColors[$task->priority] ?? $priorityColors['medium'];

    $statusColors = [
        'todo'        => ['bg' => '#f3f4f6', 'text' => '#374151'],
        'in_progress' => ['bg' => '#dbeafe', 'text' => '#1d4ed8'],
        'done'        => ['bg' => '#dcfce7', 'text' => '#15803d'],
    ];
    $sc = $statusColors[$task->status] ?? $statusColors['todo'];

    $isOverdue = $task->deadline && $task->deadline->isPast() && $task->status !== 'done';
    $isFinished = $task->status === 'done';
@endphp

<div style="background:#fff;border:1px solid {{ $isOverdue ? '#fca5a5' : '#e5e7eb' }};border-radius:10px;padding:14px;transition:box-shadow .15s;{{ $isFinished ? 'opacity:.75;' : '' }}" onmouseover="this.style.boxShadow='0 4px 16px rgba(0,0,0,.07)'" onmouseout="this.style.boxShadow='none'">

    {{-- Priority + Status --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
        <span style="background:{{ $pc['bg'] }};color:{{ $pc['text'] }};font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;letter-spacing:.3px;">{{ $pc['label'] }}</span>
        @if ($isOverdue)
            <span style="background:#fee2e2;color:#dc2626;font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;">OVERDUE</span>
        @elseif ($isFinished)
            <span style="background:#dcfce7;color:#15803d;font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:20px;">COMPLETED</span>
        @endif
    </div>

    {{-- Title --}}
    <a href="{{ route('projects.tasks.show', [$project, $task]) }}" style="font-size:14px;font-weight:700;color:#111827;text-decoration:none;display:block;margin-bottom:6px;line-height:1.35;" onmouseover="this.style.color='#1d4ed8'" onmouseout="this.style.color='#111827'">
        {{ $task->title }}
    </a>

    {{-- Description snippet --}}
    @if ($task->description)
        <p style="font-size:12px;color:#6b7280;margin:0 0 10px;line-height:1.5;">{{ Str::limit($task->description, 80) }}</p>
    @endif

    {{-- Footer --}}
    <div style="display:flex;align-items:center;justify-content:space-between;gap:6px;flex-wrap:wrap;">
        {{-- Assigned user --}}
        <div style="display:flex;align-items:center;gap:5px;">
            @if ($task->assignedUser)
                <div style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:#fff;" title="{{ $task->assignedUser->name }}">
                    {{ strtoupper(substr($task->assignedUser->name, 0, 1)) }}
                </div>
                <span style="font-size:11.5px;color:#6b7280;">{{ $task->assignedUser->name }}</span>
            @else
                <span style="font-size:11.5px;color:#9ca3af;">Unassigned</span>
            @endif
        </div>

        {{-- Deadline --}}
        @if ($task->deadline)
            <span style="font-size:11.5px;color:{{ $isOverdue ? '#dc2626' : '#6b7280' }};display:flex;align-items:center;gap:3px;">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ $isOverdue ? 'Overdue' : $task->deadline->format('M d') }}
            </span>
        @endif
    </div>

    {{-- Action Buttons --}}
    <div style="display:flex;align-items:center;gap:6px;margin-top:10px;border-top:1px solid #f3f4f6;padding-top:10px;">
        {{-- Status update (any member) --}}
        @can('changeStatus', $task)
            <form method="POST" action="{{ route('tasks.status', [$project, $task]) }}" style="flex:1;">
                @csrf @method('PATCH')
                <select name="status" onchange="this.form.submit()" style="width:100%;padding:5px 8px;border:1px solid #e5e7eb;border-radius:6px;font-size:11.5px;color:#374151;background:#fff;cursor:pointer;">
                    <option value="todo"        {{ $task->status === 'todo'        ? 'selected' : '' }}>To Do</option>
                    <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="done"        {{ $task->status === 'done'        ? 'selected' : '' }}>Done</option>
                </select>
            </form>
        @endcan

        @can('update', $task)
            <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" style="display:flex;align-items:center;justify-content:center;width:28px;height:28px;border:1px solid #e5e7eb;border-radius:6px;color:#6b7280;text-decoration:none;flex-shrink:0;" title="Edit task" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='#fff'">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            </a>
            <form method="POST" action="{{ route('projects.tasks.destroy', [$project, $task]) }}" onsubmit="return confirm('Delete this task?')" style="flex-shrink:0;">
                @csrf @method('DELETE')
                <button type="submit" style="display:flex;align-items:center;justify-content:center;width:28px;height:28px;border:1px solid #e5e7eb;border-radius:6px;color:#6b7280;background:#fff;cursor:pointer;" title="Delete task" onmouseover="this.style.background='#fef2f2';this.style.color='#dc2626'" onmouseout="this.style.background='#fff';this.style.color='#6b7280'">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                </button>
            </form>
        @endcan
    </div>
</div>
