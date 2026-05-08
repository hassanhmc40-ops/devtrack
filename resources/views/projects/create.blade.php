<x-app-layout>
    @section('title', 'Create Project')
    @section('topbar-title')
        <div class="breadcrumb">
            <a href="{{ route('projects.index') }}">PROJECTS</a>
            <span class="breadcrumb-sep">›</span>
            <span style="color:#111827;font-weight:600;">Create Project</span>
        </div>
    @endsection

    <div style="max-width:620px;margin:0 auto;">

        {{-- Modal-style Card --}}
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.06);">

            {{-- Header --}}
            <div style="padding:22px 28px 0;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <h2 style="font-size:17px;font-weight:700;color:#111827;margin:0 0 3px;">Create Project</h2>
                    <p style="font-size:13px;color:#6b7280;margin:0;">Set up your project details, timeline, and assign team members.</p>
                </div>
                <a href="{{ route('projects.index') }}" style="width:30px;height:30px;border:1px solid #e5e7eb;border-radius:7px;display:flex;align-items:center;justify-content:center;color:#6b7280;text-decoration:none;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='#fff'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </a>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('projects.store') }}" id="create-project-form">
                @csrf

                <div style="padding:22px 28px;">

                    {{-- Project Title --}}
                    <div class="form-group">
                        <label class="form-label" for="title">Project Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                            placeholder="e.g. Marketing Campaign, DevTrack v2..."
                            class="form-input {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            required autofocus>
                        @error('title') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" rows="4"
                            placeholder="Describe the goal, scope, and key deliverables of this project..."
                            class="form-input {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                        @error('description') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- Deadline --}}
                    <div class="form-group">
                        <label class="form-label" for="deadline">Deadline</label>
                        <div style="position:relative;">
                            <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#9ca3af;" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}"
                                class="form-input {{ $errors->has('deadline') ? 'is-invalid' : '' }}"
                                style="padding-left:34px;">
                        </div>
                        @error('deadline') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- Info note --}}
                    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:11px 14px;font-size:12.5px;color:#1d4ed8;display:flex;align-items:flex-start;gap:8px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        You will be assigned as <strong>Team Lead</strong> automatically. Add team members from the project page after creation.
                    </div>
                </div>

                {{-- Footer --}}
                <div style="padding:16px 28px;border-top:1px solid #f3f4f6;display:flex;align-items:center;justify-content:flex-end;gap:10px;">
                    <a href="{{ route('projects.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary" id="create-project-submit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Create Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
