<x-app-layout>
    @section('title', 'Create Task')
    @section('topbar-title')
        <div class="breadcrumb">
            <a href="{{ route('projects.index') }}">PROJECTS</a>
            <span class="breadcrumb-sep">›</span>
            <a href="{{ route('projects.show', $project) }}">{{ $project->title }}</a>
            <span class="breadcrumb-sep">›</span>
            <span style="color:#111827;font-weight:600;">New Task</span>
        </div>
    @endsection

    <div style="max-width:580px;margin:0 auto;">
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:14px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.06);">

            {{-- Header --}}
            <div style="padding:22px 28px 0;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <h2 style="font-size:16px;font-weight:700;color:#111827;margin:0 0 2px;">Create New Task</h2>
                    <p style="font-size:12.5px;color:#6b7280;margin:0;">Add a task and assign it to a team member.</p>
                </div>
                <a href="{{ route('projects.show', $project) }}" style="width:30px;height:30px;border:1px solid #e5e7eb;border-radius:7px;display:flex;align-items:center;justify-content:center;color:#6b7280;text-decoration:none;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='#fff'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </a>
            </div>

            <form method="POST" action="{{ route('projects.tasks.store', $project) }}" id="create-task-form">
                @csrf

                <div style="padding:20px 28px;">

                    {{-- Title --}}
                    <div class="form-group">
                        <label class="form-label" for="title">Task Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                            placeholder="e.g. Refactor Authentication Middleware..."
                            class="form-input {{ $errors->has('title') ? 'is-invalid' : '' }}"
                            required autofocus>
                        @error('title') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" rows="3"
                            placeholder="Describe what needs to be done..."
                            class="form-input {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                        @error('description') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- Priority + Status --}}
                    <div class="form-row">
                        <div>
                            <label class="form-label" for="priority">Priority *</label>
                            <select id="priority" name="priority"
                                class="form-input {{ $errors->has('priority') ? 'is-invalid' : '' }}"
                                required>
                                <option value="">Select priority...</option>
                                <option value="low"    {{ old('priority') === 'low'    ? 'selected' : '' }}>🟢 Low</option>
                                <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                <option value="high"   {{ old('priority') === 'high'   ? 'selected' : '' }}>🔴 High</option>
                            </select>
                            @error('priority') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="form-label" for="status">Status</label>
                            <select id="status" name="status"
                                class="form-input {{ $errors->has('status') ? 'is-invalid' : '' }}">
                                <option value="todo"        {{ old('status', 'todo') === 'todo'        ? 'selected' : '' }}>To Do</option>
                                <option value="in_progress" {{ old('status') === 'in_progress'         ? 'selected' : '' }}>In Progress</option>
                                <option value="done"        {{ old('status') === 'done'                ? 'selected' : '' }}>Done</option>
                            </select>
                            @error('status') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Deadline + Assigned --}}
                    <div class="form-row">
                        <div>
                            <label class="form-label" for="deadline">Deadline</label>
                            <div style="position:relative;">
                                <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);color:#9ca3af;" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                <input type="date" id="deadline" name="deadline"
                                    value="{{ old('deadline') }}"
                                    class="form-input {{ $errors->has('deadline') ? 'is-invalid' : '' }}"
                                    style="padding-left:34px;">
                            </div>
                            @error('deadline') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="form-label" for="assigned_to">Assign To *</label>
                            <select id="assigned_to" name="assigned_to"
                                class="form-input {{ $errors->has('assigned_to') ? 'is-invalid' : '' }}"
                                required>
                                <option value="">Select a member...</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('assigned_to') == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }} ({{ ucfirst($member->pivot->role) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                </div>

                {{-- Footer --}}
                <div style="padding:16px 28px;border-top:1px solid #f3f4f6;display:flex;align-items:center;justify-content:flex-end;gap:10px;">
                    <a href="{{ route('projects.show', $project) }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary" id="create-task-submit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Create Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
