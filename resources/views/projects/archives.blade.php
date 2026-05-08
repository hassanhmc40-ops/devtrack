<x-app-layout>
    @section('title', 'Project Archives')
    @section('topbar-title', 'Project Archives')

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
        <div>
            <h1 style="font-size:22px;font-weight:700;color:#111827;margin:0 0 4px;">Project Archives</h1>
            <p style="font-size:13.5px;color:#6b7280;margin:0;">Archived projects are hidden from your dashboard. Restore or permanently delete them here.</p>
        </div>
        <a href="{{ route('projects.index') }}" class="btn-secondary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Projects
        </a>
    </div>

    @if ($archivedProjects->isEmpty())
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:64px;text-align:center;">
            <div style="width:56px;height:56px;background:#f3f4f6;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
            </div>
            <h3 style="font-size:16px;font-weight:600;color:#374151;margin:0 0 8px;">No archived projects</h3>
            <p style="font-size:13.5px;color:#6b7280;margin:0;">Projects you archive will appear here.</p>
        </div>
    @else
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#f9fafb;border-bottom:1px solid #e5e7eb;">
                        <th style="text-align:left;padding:12px 20px;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;">Project</th>
                        <th style="text-align:left;padding:12px 20px;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;">Tasks</th>
                        <th style="text-align:left;padding:12px 20px;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;">Deadline</th>
                        <th style="text-align:left;padding:12px 20px;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;">Archived</th>
                        <th style="text-align:right;padding:12px 20px;font-size:12px;font-weight:600;color:#6b7280;text-transform:uppercase;letter-spacing:.5px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($archivedProjects as $project)
                        <tr style="border-bottom:1px solid #f3f4f6;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='#fff'">
                            <td style="padding:16px 20px;">
                                <div style="font-size:14px;font-weight:600;color:#374151;">{{ $project->title }}</div>
                                @if ($project->description)
                                    <div style="font-size:12px;color:#9ca3af;margin-top:2px;">{{ Str::limit($project->description, 60) }}</div>
                                @endif
                            </td>
                            <td style="padding:16px 20px;">
                                <span style="font-size:13.5px;color:#374151;font-weight:500;">{{ $project->tasks_count }}</span>
                                <span style="font-size:12px;color:#9ca3af;"> tasks</span>
                            </td>
                            <td style="padding:16px 20px;">
                                @if ($project->deadline)
                                    <span style="font-size:13px;color:#374151;">{{ $project->deadline->format('M d, Y') }}</span>
                                @else
                                    <span style="font-size:13px;color:#9ca3af;">No deadline</span>
                                @endif
                            </td>
                            <td style="padding:16px 20px;">
                                <span style="font-size:13px;color:#6b7280;">{{ $project->deleted_at->diffForHumans() }}</span>
                            </td>
                            <td style="padding:16px 20px;text-align:right;">
                                <div style="display:flex;align-items:center;justify-content:flex-end;gap:8px;">
                                    {{-- Restore --}}
                                    @can('restore', $project)
                                        <form method="POST" action="{{ route('projects.restore', $project->id) }}">
                                            @csrf
                                            <button type="submit" class="btn-secondary" style="font-size:12.5px;padding:6px 12px;" title="Restore project">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
                                                Restore
                                            </button>
                                        </form>
                                    @endcan

                                    {{-- Permanent Delete --}}
                                    @can('forceDelete', $project)
                                        <form method="POST" action="{{ route('projects.forceDelete', $project->id) }}" onsubmit="return confirm('This will PERMANENTLY delete the project and all its tasks. This cannot be undone!')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-danger" style="font-size:12.5px;padding:6px 12px;" id="force-delete-{{ $project->id }}">
                                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                                Delete Forever
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-app-layout>
