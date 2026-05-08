<x-app-layout>
    @section('title', $project->title)
    @section('topbar-title')
        <div class="breadcrumb">
            <a href="{{ route('projects.index') }}">PROJECTS</a>
            <span class="breadcrumb-sep">›</span>
            <span style="color:#111827;font-weight:600;">{{ $project->title }}</span>
        </div>
    @endsection

    @section('topbar-actions')
        @can('update', $project)
            <a href="{{ route('projects.edit', $project) }}" class="btn-secondary" style="font-size:12.5px;padding:6px 12px;" id="edit-project-btn">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form method="POST" action="{{ route('projects.destroy', $project) }}" id="archive-project-form" onsubmit="return confirm('Archive this project?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-secondary" style="font-size:12.5px;padding:6px 12px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                    Archive
                </button>
            </form>
        @endcan
    @endsection

    {{-- Project Header --}}
    <div style="margin-bottom:20px;">
        <h1 style="font-size:22px;font-weight:700;color:#111827;margin:0 0 4px;">{{ $project->title }}</h1>
        <p style="font-size:13.5px;color:#6b7280;margin:0 0 16px;">{{ $project->description ?? 'Next generation task orchestration for agile engineering teams.' }}</p>

        <div style="display:flex;align-items:center;gap:24px;flex-wrap:wrap;">
            {{-- Active Team --}}
            <div>
                <div style="font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Active Team</div>
                <div style="display:flex;align-items:center;">
                    @foreach ($project->users->take(5) as $member)
                        <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#1d4ed8,#3b82f6);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;color:#fff;border:2px solid #fff;margin-left:{{ $loop->first ? '0' : '-8px' }};" title="{{ $member->name }} ({{ ucfirst($member->pivot->role) }})">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Project Status --}}
            <div>
                <div style="font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Project Status</div>
                <div style="display:flex;align-items:center;gap:6px;">
                    <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
                    <span style="font-size:13px;font-weight:600;color:#111827;">On Track</span>
                </div>
            </div>

            @if ($project->deadline)
            <div>
                <div style="font-size:11px;font-weight:600;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:6px;">Deadline</div>
                <div style="font-size:13px;font-weight:600;color:{{ $project->deadline->isPast() ? '#dc2626' : '#111827' }};">{{ $project->deadline->format('M d, Y') }}</div>
            </div>
            @endif
        </div>
    </div>

    {{-- Add Member (lead only) --}}
    @can('update', $project)
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:14px 18px;margin-bottom:24px;display:flex;align-items:center;gap:12px;" x-data="{ showAddMember: false }">
            <button @click="showAddMember = !showAddMember" style="font-size:13px;font-weight:600;color:#1d4ed8;background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                Add Team Member
            </button>
            <div x-show="showAddMember" style="flex:1;">
                <form method="POST" action="{{ route('projects.members.store', $project) }}" style="display:flex;gap:8px;">
                    @csrf
                    <input type="email" name="email" placeholder="member@company.com" class="form-input" style="max-width:280px;padding:8px 12px;" id="member-email-input">
                    @error('email') <span style="font-size:12px;color:#dc2626;">{{ $message }}</span> @enderror
                    <button type="submit" class="btn-primary" style="padding:8px 14px;font-size:13px;" id="add-member-submit">Add</button>
                </form>
            </div>

            {{-- Current members list --}}
            <div style="display:flex;align-items:center;gap:8px;margin-left:auto;">
                @foreach ($project->users as $member)
                    <div style="display:flex;align-items:center;gap:6px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:20px;padding:4px 10px 4px 4px;">
                        <div style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,#1d4ed8,#3b82f6);display:flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;color:#fff;">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                        <span style="font-size:12px;color:#374151;font-weight:500;">{{ $member->name }}</span>
                        <span style="font-size:10.5px;color:{{ $member->pivot->role === 'lead' ? '#1d4ed8' : '#6b7280' }};font-weight:600;">{{ ucfirst($member->pivot->role) }}</span>
                        @if ($member->pivot->role !== 'lead')
                            <form method="POST" action="{{ route('projects.members.destroy', [$project, $member]) }}" style="margin-left:2px;" onsubmit="return confirm('Remove this member?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:none;border:none;cursor:pointer;color:#9ca3af;line-height:0;padding:0;" title="Remove">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endcan

    {{-- Kanban Board --}}
    @php
        $todoTasks       = $project->tasks->where('status', 'todo');
        $inProgressTasks = $project->tasks->where('status', 'in_progress');
        $doneTasks       = $project->tasks->where('status', 'done');
    @endphp

    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;align-items:start;">

        {{-- TO DO Column --}}
        <div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="font-size:13px;font-weight:700;color:#374151;text-transform:uppercase;letter-spacing:.5px;">TO DO</span>
                    <span style="background:#f3f4f6;color:#374151;font-size:12px;font-weight:700;padding:2px 8px;border-radius:20px;">{{ $todoTasks->count() }}</span>
                </div>
                @can('update', $project)
                    <a href="{{ route('projects.tasks.create', $project) }}" style="color:#9ca3af;text-decoration:none;" title="Add task" id="add-todo-task">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </a>
                @endcan
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;">
                @forelse ($todoTasks as $task)
                    @include('projects._task_card', ['task' => $task, 'project' => $project, 'columnColor' => '#6b7280'])
                @empty
                    <div style="background:#f9fafb;border:1px dashed #e5e7eb;border-radius:10px;padding:20px;text-align:center;font-size:12.5px;color:#9ca3af;">No tasks yet</div>
                @endforelse
            </div>
        </div>

        {{-- IN PROGRESS Column --}}
        <div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="font-size:13px;font-weight:700;color:#1d4ed8;text-transform:uppercase;letter-spacing:.5px;">IN PROGRESS</span>
                    <span style="background:#dbeafe;color:#1d4ed8;font-size:12px;font-weight:700;padding:2px 8px;border-radius:20px;">{{ $inProgressTasks->count() }}</span>
                </div>
                @can('update', $project)
                    <a href="{{ route('projects.tasks.create', $project) }}" style="color:#9ca3af;text-decoration:none;" title="Add task" id="add-inprogress-task">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </a>
                @endcan
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;">
                @forelse ($inProgressTasks as $task)
                    @include('projects._task_card', ['task' => $task, 'project' => $project, 'columnColor' => '#1d4ed8'])
                @empty
                    <div style="background:#f9fafb;border:1px dashed #e5e7eb;border-radius:10px;padding:20px;text-align:center;font-size:12.5px;color:#9ca3af;">No tasks yet</div>
                @endforelse
            </div>
        </div>

        {{-- DONE Column --}}
        <div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="font-size:13px;font-weight:700;color:#15803d;text-transform:uppercase;letter-spacing:.5px;">DONE</span>
                    <span style="background:#dcfce7;color:#15803d;font-size:12px;font-weight:700;padding:2px 8px;border-radius:20px;">{{ $doneTasks->count() }}</span>
                </div>
                @can('update', $project)
                    <a href="{{ route('projects.tasks.create', $project) }}" style="color:#9ca3af;text-decoration:none;" title="Add task" id="add-done-task">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    </a>
                @endcan
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;">
                @forelse ($doneTasks as $task)
                    @include('projects._task_card', ['task' => $task, 'project' => $project, 'columnColor' => '#15803d'])
                @empty
                    <div style="background:#f9fafb;border:1px dashed #e5e7eb;border-radius:10px;padding:20px;text-align:center;font-size:12.5px;color:#9ca3af;">No tasks yet</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- FAB: Add Task --}}
    @can('update', $project)
        <a href="{{ route('projects.tasks.create', $project) }}" id="fab-add-task" style="position:fixed;bottom:32px;right:32px;width:52px;height:52px;background:#1d4ed8;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 20px rgba(29,78,216,.4);text-decoration:none;color:#fff;transition:all .2s;" onmouseover="this.style.background='#1e40af';this.style.transform='scale(1.08)'" onmouseout="this.style.background='#1d4ed8';this.style.transform='scale(1)'">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        </a>
    @endcan
</x-app-layout>
