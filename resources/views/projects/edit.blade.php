<x-app-layout>
    @section('title', 'Edit Project')
    @section('topbar-title')
        <div class="breadcrumb">
            <a href="{{ route('projects.index') }}">PROJECTS</a>
            <span class="breadcrumb-sep">›</span>
            <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
            <span class="breadcrumb-sep">›</span>
            <span style="color:#111827;font-weight:600;">Edit Project</span>
        </div>
    @endsection

    <div style="max-width:700px;margin:0 auto;">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.06);">

            {{-- Header --}}
            <div style="padding:22px 28px 0;display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:22px;">
                <div>
                    <h2 style="font-size:17px;font-weight:700;color:#111827;margin:0 0 3px;">Edit Project Settings</h2>
                    <p style="font-size:13px;color:#6b7280;margin:0;">Modify your project details, deadlines, and timezone. All team members will be updated on any significant deadline changes.</p>
                </div>
                <a href="{{ route('projects.show', $project) }}" style="width:30px;height:30px;border:1px solid #e5e7eb;border-radius:7px;display:flex;align-items:center;justify-content:center;color:#6b7280;text-decoration:none;flex-shrink:0;margin-left:16px;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='#fff'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </a>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('projects.update', $project) }}" id="edit-project-form">
                @csrf @method('PUT')

                <div style="padding:0 28px 22px;">

                    {{-- Project Title --}}
                    <div class="form-group">
                        <label class="form-label" for="title">Project Title *</label>
                        <input type="text" id="title" name="title"
                            value="{{ old('title', $project->title) }}"
                            placeholder="Project title..."
                            class="form-input {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            required>
                        @error('title') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" rows="5"
                            placeholder="Describe the project objectives..."
                            class="form-input {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description', $project->description) }}</textarea>
                        @error('description') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- Deadline + Status row --}}
                    <div class="form-row">
                        <div>
                            <label class="form-label" for="deadline">Deadline</label>
                            <div style="position:relative;">
                                <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#9ca3af;" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <input type="date" id="deadline" name="deadline"
                                    value="{{ old('deadline', $project->deadline?->format('Y-m-d')) }}"
                                    class="form-input {{ $errors->has('deadline') ? 'is-invalid' : '' }}"
                                    style="padding-left:34px;">
                            </div>
                            @error('deadline') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="form-label">Current Status</label>
                            <div style="padding:10px 14px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;display:flex;align-items:center;gap:8px;">
                                <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
                                <span style="font-size:13.5px;color:#374151;font-weight:500;">In Progress</span>
                            </div>
                        </div>
                    </div>

                    {{-- Project Stats (read-only info) --}}
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:8px;">
                        @php
                            $contributors = $project->users->count();
                            $tasksDone    = $project->tasks->where('status','done')->count();
                            $totalTasks   = $project->tasks->count();
                            $velocity     = $totalTasks > 0 ? round(($tasksDone/$totalTasks)*100) : 0;
                        @endphp
                        <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:12px;text-align:center;">
                            <div style="display:flex;align-items:center;justify-content:center;margin-bottom:4px;">
                                @foreach ($project->users->take(3) as $u)
                                    <div style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,#1d4ed8,#3b82f6);border:2px solid #fff;margin-left:{{ $loop->first ? '0' : '-6px' }};font-size:9px;font-weight:700;color:#fff;display:flex;align-items:center;justify-content:center;">{{ strtoupper(substr($u->name,0,1)) }}</div>
                                @endforeach
                            </div>
                            <div style="font-size:10.5px;color:#6b7280;font-weight:500;">{{ $contributors }} Contributors</div>
                        </div>
                        <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:12px;text-align:center;">
                            <div style="font-size:18px;font-weight:700;color:#1d4ed8;margin-bottom:2px;">{{ $velocity }}%</div>
                            <div style="font-size:10.5px;color:#6b7280;font-weight:500;">Velocity</div>
                        </div>
                        <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:12px;text-align:center;">
                            <div style="font-size:12px;font-weight:600;color:#374151;margin-bottom:2px;">{{ $project->updated_at->diffForHumans() }}</div>
                            <div style="font-size:10.5px;color:#6b7280;font-weight:500;">Last Update</div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div style="padding:16px 28px;border-top:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;">
                    <a href="{{ route('projects.show', $project) }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary" id="update-project-submit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Update Project
                    </button>
                </div>
            </form>
        </div>

        {{-- Danger Zone --}}
        <div style="background:#fff;border:1px solid #fca5a5;border-radius:14px;margin-top:16px;overflow:hidden;">
            <div style="padding:18px 28px;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <div style="font-size:14px;font-weight:700;color:#dc2626;margin-bottom:2px;">Archive Project</div>
                    <div style="font-size:12.5px;color:#6b7280;">Move this project to archives. You can restore it later.</div>
                </div>
                <form method="POST" action="{{ route('projects.destroy', $project) }}" onsubmit="return confirm('Archive this project? You can restore it from the archives.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger" style="font-size:13px;padding:8px 16px;" id="archive-btn">
                        Archive Project
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
