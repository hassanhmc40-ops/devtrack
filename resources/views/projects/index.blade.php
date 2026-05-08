<x-app-layout>
    @section('title', 'My Projects')
    @section('topbar-title', 'My Projects')

    @section('topbar-actions')
        @can('create', App\Models\Project::class)
            <a href="{{ route('projects.create') }}" class="btn-primary" id="create-project-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Create Project
            </a>
        @endcan
    @endsection

    {{-- Page Header --}}
    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px;font-weight:700;color:#111827;margin:0 0 4px;">My Projects</h1>
        <p style="font-size:13.5px;color:#6b7280;margin:0;">Manage your active development sprints and track team progress.</p>
    </div>

    {{-- Stats Row --}}
    @php
        $totalTasks     = $projects->sum('tasks_count');
        $completedTasks = $projects->sum('completed_tasks_count');
        $pendingTasks   = $totalTasks - $completedTasks;
        $overdueTasks   = 0;
        foreach ($projects as $p) {
            foreach ($p->tasks ?? [] as $t) {
                if ($t->deadline && $t->deadline->isPast() && $t->status !== 'done') $overdueTasks++;
            }
        }
    @endphp

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px;">

        {{-- Total Tasks --}}
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px 20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;">Total Tasks</span>
                <span style="font-size:11px;font-weight:600;color:#1d4ed8;background:#eff6ff;padding:2px 8px;border-radius:20px;">+8%</span>
            </div>
            <div style="font-size:32px;font-weight:800;color:#111827;">{{ $totalTasks }}</div>
            <div style="font-size:12px;color:#6b7280;margin-top:2px;">Across all projects</div>
        </div>

        {{-- Pending --}}
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px 20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;">Pending</span>
                <span style="font-size:11px;font-weight:600;color:#d97706;background:#fef3c7;padding:2px 8px;border-radius:20px;">Active</span>
            </div>
            <div style="font-size:32px;font-weight:800;color:#111827;">{{ $pendingTasks }}</div>
            <div style="font-size:12px;color:#6b7280;margin-top:2px;">Not yet completed</div>
        </div>

        {{-- Completed --}}
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px 20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;">Completed</span>
                <span style="font-size:11px;font-weight:600;color:#15803d;background:#dcfce7;padding:2px 8px;border-radius:20px;">Goal Met</span>
            </div>
            <div style="font-size:32px;font-weight:800;color:#111827;">{{ $completedTasks }}</div>
            <div style="font-size:12px;color:#6b7280;margin-top:2px;">Tasks finished</div>
        </div>

        {{-- Overdue --}}
        <div style="background:#fff;border:1px solid #fca5a5;border-radius:12px;padding:18px 20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span style="font-size:12px;font-weight:600;color:#dc2626;text-transform:uppercase;letter-spacing:.5px;">Overdue</span>
                <span style="font-size:11px;font-weight:600;color:#dc2626;background:#fee2e2;padding:2px 8px;border-radius:20px;">High Alert</span>
            </div>
            <div style="font-size:32px;font-weight:800;color:#dc2626;">{{ $overdueTasks }}</div>
            <div style="font-size:12px;color:#ef4444;margin-top:2px;">Needs attention</div>
        </div>
    </div>

    {{-- Projects Grid --}}
    @if ($projects->isEmpty())
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:60px;text-align:center;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 16px;display:block;"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
            <h3 style="font-size:16px;font-weight:600;color:#374151;margin:0 0 8px;">No projects yet</h3>
            <p style="font-size:13.5px;color:#6b7280;margin:0 0 20px;">You haven't been added to any projects yet.</p>
            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}" class="btn-primary">+ Create your first project</a>
            @endcan
        </div>
    @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:18px;">
            @foreach ($projects as $project)
                @php
                    $total     = $project->tasks_count ?? 0;
                    $completed = $project->completed_tasks_count ?? 0;
                    $progress  = $total > 0 ? round(($completed / $total) * 100) : 0;
                    $colors    = ['#1d4ed8','#16a34a','#7c3aed','#dc2626','#d97706'];
                    $color     = $colors[$loop->index % count($colors)];
                @endphp
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;display:flex;flex-direction:column;gap:14px;transition:box-shadow .15s;" onmouseover="this.style.boxShadow='0 4px 20px rgba(0,0,0,.08)'" onmouseout="this.style.boxShadow='none'">

                    {{-- Project Header --}}
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;">
                        <div>
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                                <span style="width:10px;height:10px;border-radius:50%;background:{{ $color }};display:inline-block;"></span>
                                <a href="{{ route('projects.show', $project) }}" style="font-size:14.5px;font-weight:700;color:#111827;text-decoration:none;">{{ $project->title }}</a>
                            </div>
                            <p style="font-size:12.5px;color:#6b7280;margin:0;line-height:1.5;max-height:36px;overflow:hidden;">{{ Str::limit($project->description, 75) }}</p>
                        </div>
                        @can('update', $project)
                            <div style="position:relative;" x-data="{ open: false }">
                                <button @click="open = !open" style="background:none;border:none;cursor:pointer;color:#9ca3af;padding:2px 4px;border-radius:4px;" class="icon-btn" style="border:none;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" style="position:absolute;right:0;top:24px;background:#fff;border:1px solid #e5e7eb;border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,.1);min-width:140px;z-index:20;overflow:hidden;">
                                    <a href="{{ route('projects.edit', $project) }}" style="display:flex;align-items:center;gap:8px;padding:9px 14px;font-size:13px;color:#374151;text-decoration:none;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Archive this project?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="display:flex;align-items:center;gap:8px;padding:9px 14px;font-size:13px;color:#dc2626;background:none;border:none;cursor:pointer;width:100%;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='none'">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                                            Archive
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endcan
                    </div>

                    {{-- Progress --}}
                    <div>
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                            <span style="font-size:12px;font-weight:600;color:#6b7280;">Progress</span>
                            <span style="font-size:12px;color:#6b7280;">{{ $completed }}/{{ $total }} Tasks</span>
                        </div>
                        <div style="height:5px;background:#f3f4f6;border-radius:99px;overflow:hidden;">
                            <div style="height:100%;width:{{ $progress }}%;background:{{ $color }};border-radius:99px;transition:width .3s;"></div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <div style="display:flex;align-items:center;">
                            @foreach ($project->users->take(3) as $member)
                                <div style="width:26px;height:26px;border-radius:50%;background:linear-gradient(135deg,#1d4ed8,#3b82f6);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff;border:2px solid #fff;margin-left:-6px;" title="{{ $member->name }}">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endforeach
                            @if ($project->users->count() > 3)
                                <div style="width:26px;height:26px;border-radius:50%;background:#f3f4f6;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#6b7280;border:2px solid #fff;margin-left:-6px;">+{{ $project->users->count() - 3 }}</div>
                            @endif
                        </div>

                        @if ($project->deadline)
                            <div style="display:flex;align-items:center;gap:4px;font-size:12px;color:{{ $project->deadline->isPast() ? '#dc2626' : '#6b7280' }};">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $project->deadline->isPast() ? 'Overdue' : $project->deadline->format('M d, Y') }}
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('projects.show', $project) }}" class="btn-secondary" style="text-align:center;justify-content:center;font-size:13px;padding:8px;">
                        View Project
                    </a>
                </div>
            @endforeach

            {{-- Start New Project card --}}
            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}" style="background:#fff;border:2px dashed #e5e7eb;border-radius:12px;padding:20px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;min-height:180px;text-decoration:none;color:#9ca3af;transition:all .15s;" id="new-project-card" onmouseover="this.style.borderColor='#1d4ed8';this.style.color='#1d4ed8'" onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#9ca3af'">
                    <div style="width:40px;height:40px;border-radius:50%;border:2px dashed currentColor;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:300;">+</div>
                    <div style="text-align:center;">
                        <div style="font-size:13.5px;font-weight:600;color:inherit;margin-bottom:2px;">Start New Project</div>
                        <div style="font-size:12px;color:#9ca3af;">Create a new repository and team board</div>
                    </div>
                </a>
            @endcan
        </div>
    @endif
</x-app-layout>
