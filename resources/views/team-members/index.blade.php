<x-app-layout>
    @section('title', 'Team Members')
    @section('topbar-title', 'Team Members')

    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px;font-weight:700;color:#111827;margin:0 0 4px;">Team Members</h1>
        <p style="font-size:13.5px;color:#6b7280;margin:0;">View all members across the projects you are part of.</p>
    </div>

    @if ($members->isEmpty())
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:40px;text-align:center;">
            <h3 style="font-size:16px;font-weight:600;color:#374151;margin-bottom:8px;">No team members found</h3>
            <p style="font-size:13.5px;color:#6b7280;margin:0;">You are not yet part of a project with members assigned.</p>
        </div>
    @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:18px;">
            @foreach ($members as $member)
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px;">
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;">
                        <div style="width:42px;height:42px;border-radius:50%;background:#1d4ed8;color:#fff;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                        <div>
                            <div style="font-size:15px;font-weight:700;color:#111827;">{{ $member->name }}</div>
                            <div style="font-size:12.5px;color:#6b7280;">{{ $member->email }}</div>
                        </div>
                    </div>

                    <div style="font-size:12.5px;color:#6b7280;line-height:1.6;">
                        Projects:
                        <span style="color:#111827;font-weight:600;">
                            {{ $member->projects->pluck('title')->unique()->join(', ') ?: 'No projects assigned' }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
