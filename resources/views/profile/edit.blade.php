<x-app-layout>
    @section('title', 'Settings')
    @section('topbar-title', 'Settings')

    @php
        $userRole = 'Member';
        // Try to get a role from any project
        $firstProject = $user->projects()->withPivot('role')->first();
        if ($firstProject) {
            $userRole = ucfirst($firstProject->pivot->role);
        }
    @endphp

    <div style="margin-bottom:24px;">
        <h1 style="font-size:22px;font-weight:700;color:#111827;margin:0 0 4px;">Settings</h1>
        <p style="font-size:13.5px;color:#6b7280;margin:0;">Manage your account preferences and security settings.</p>
    </div>

    {{-- Tabs --}}
    <div style="display:flex;gap:0;border-bottom:2px solid #e5e7eb;margin-bottom:24px;" x-data="{ tab: 'profile' }">
        <button @click="tab = 'profile'" :style="tab === 'profile' ? 'border-bottom:2px solid #1d4ed8;color:#1d4ed8;margin-bottom:-2px;' : 'color:#6b7280;'" style="padding:8px 20px;background:none;border:none;border-bottom:2px solid transparent;font-size:13.5px;font-weight:600;cursor:pointer;transition:all .15s;" id="tab-profile">Profile</button>
        <button @click="tab = 'security'" :style="tab === 'security' ? 'border-bottom:2px solid #1d4ed8;color:#1d4ed8;margin-bottom:-2px;' : 'color:#6b7280;'" style="padding:8px 20px;background:none;border:none;border-bottom:2px solid transparent;font-size:13.5px;font-weight:600;cursor:pointer;transition:all .15s;" id="tab-security">Security</button>
        <button @click="tab = 'notifications'" :style="tab === 'notifications' ? 'border-bottom:2px solid #1d4ed8;color:#1d4ed8;margin-bottom:-2px;' : 'color:#6b7280;'" style="padding:8px 20px;background:none;border:none;border-bottom:2px solid transparent;font-size:13.5px;font-weight:600;cursor:pointer;transition:all .15s;" id="tab-notifications">Notifications</button>
    </div>

    <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;" x-data="{ tab: 'profile' }">

        {{-- Tabs Nav (inline with content) --}}
        <div>
            {{-- Profile Tab --}}
            <div x-show="tab === 'profile'" x-cloak>
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                    <div style="padding:20px 24px;border-bottom:1px solid #f3f4f6;">
                        <h3 style="font-size:15px;font-weight:700;color:#111827;margin:0 0 2px;">Personal Information</h3>
                        <p style="font-size:12.5px;color:#6b7280;margin:0;">Update your display name and email address.</p>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" style="padding:22px 24px;">
                        @csrf @method('PATCH')

                        @if (session('status') === 'profile-updated')
                            <div class="flash-success">Profile updated successfully!</div>
                        @endif

                        <div style="display:flex;align-items:center;gap:16px;margin-bottom:22px;">
                            <div style="width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#1d4ed8,#3b82f6);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;color:#fff;flex-shrink:0;">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                            <div>
                                <div style="font-size:15px;font-weight:700;color:#111827;">{{ $user->name }}</div>
                                <div style="font-size:12.5px;color:#6b7280;">{{ $user->email }}</div>
                                <div style="font-size:11.5px;color:#1d4ed8;font-weight:600;margin-top:2px;">{{ $userRole }}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="name">Full Name</label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', $user->name) }}"
                                class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                required>
                            @error('name') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $user->email) }}"
                                class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                required>
                            @error('email') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div style="display:flex;justify-content:flex-end;margin-top:6px;">
                            <button type="submit" class="btn-primary" id="save-profile-btn">Save Changes</button>
                        </div>
                    </form>
                </div>

                {{-- Security section --}}
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;margin-top:16px;overflow:hidden;">
                    <div style="padding:18px 24px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <div style="font-size:14px;font-weight:700;color:#111827;margin-bottom:1px;">Password</div>
                            <div style="font-size:12px;color:#6b7280;">Changed 3 months ago</div>
                        </div>
                        <a href="#" style="font-size:13px;font-weight:600;color:#1d4ed8;text-decoration:none;" id="change-password-link">Update</a>
                    </div>
                    <div style="padding:18px 24px;display:flex;align-items:center;justify-content:space-between;">
                        <div>
                            <div style="font-size:14px;font-weight:700;color:#111827;margin-bottom:1px;">Two Factor Auth</div>
                            <div style="font-size:12px;color:#6b7280;">Not enabled</div>
                        </div>
                        <a href="#" style="font-size:13px;font-weight:600;color:#1d4ed8;text-decoration:none;" id="enable-2fa-link">Manage</a>
                    </div>
                </div>
            </div>

            {{-- Security Tab --}}
            <div x-show="tab === 'security'" x-cloak>
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                    <div style="padding:20px 24px;border-bottom:1px solid #f3f4f6;">
                        <h3 style="font-size:15px;font-weight:700;color:#111827;margin:0 0 2px;">Change Password</h3>
                        <p style="font-size:12.5px;color:#6b7280;margin:0;">Use a strong password of at least 8 characters.</p>
                    </div>
                    <div style="padding:22px 24px;">
                        <div style="font-size:13.5px;color:#6b7280;text-align:center;padding:20px 0;">
                            Password management is handled via the standard Laravel auth flow.
                        </div>
                    </div>
                </div>

                {{-- Delete Account --}}
                <div style="background:#fff;border:1px solid #fca5a5;border-radius:12px;margin-top:16px;overflow:hidden;">
                    <div style="padding:20px 24px;border-bottom:1px solid #fecaca;">
                        <h3 style="font-size:15px;font-weight:700;color:#dc2626;margin:0 0 2px;">Delete Account</h3>
                        <p style="font-size:12.5px;color:#6b7280;margin:0;">Permanently delete your account and all associated data.</p>
                    </div>
                    <div style="padding:20px 24px;">
                        <form method="POST" action="{{ route('profile.destroy') }}"
                            onsubmit="return confirm('This will permanently delete your account. Are you absolutely sure?')">
                            @csrf @method('DELETE')
                            <div class="form-group">
                                <label class="form-label" for="delete_password">Confirm your password</label>
                                <input type="password" id="delete_password" name="password"
                                    class="form-input" placeholder="Enter your password to confirm">
                                @error('password', 'userDeletion') <div class="form-error">{{ $message }}</div> @enderror
                            </div>
                            <button type="submit" class="btn-danger" id="delete-account-btn">Delete My Account</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Notifications Tab --}}
            <div x-show="tab === 'notifications'" x-cloak>
                <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                    <div style="padding:20px 24px;border-bottom:1px solid #f3f4f6;">
                        <h3 style="font-size:15px;font-weight:700;color:#111827;margin:0 0 2px;">Notification Preferences</h3>
                        <p style="font-size:12.5px;color:#6b7280;margin:0;">Control what updates you receive.</p>
                    </div>
                    <div style="padding:20px 24px;display:flex;flex-direction:column;gap:16px;">
                        @foreach (['Task assignments' => true, 'Deadline reminders' => true, 'Project updates' => true, 'New team members' => false] as $label => $default)
                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                <span style="font-size:13.5px;color:#374151;font-weight:500;">{{ $label }}</span>
                                <label style="position:relative;display:inline-block;width:40px;height:22px;cursor:pointer;">
                                    <input type="checkbox" {{ $default ? 'checked' : '' }} style="opacity:0;width:0;height:0;">
                                    <span style="position:absolute;inset:0;background:{{ $default ? '#1d4ed8' : '#d1d5db' }};border-radius:22px;transition:.15s;"></span>
                                    <span style="position:absolute;left:{{ $default ? '20px' : '3px' }};top:3px;width:16px;height:16px;background:#fff;border-radius:50%;transition:.15s;"></span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Panel: Subscription / Workspace --}}
        <div>
            <div style="background:#1d4ed8;border-radius:12px;padding:20px;margin-bottom:14px;color:#fff;">
                <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;opacity:.7;margin-bottom:6px;">PRO PLAN</div>
                <div style="font-size:16px;font-weight:700;margin-bottom:4px;">Manage Subscription</div>
                <div style="font-size:12.5px;opacity:.8;margin-bottom:16px;line-height:1.5;">Your next billing cycle is on Jun 15, 2026. Cancel anytime.</div>
                <a href="#" style="display:inline-block;background:rgba(255,255,255,.2);color:#fff;font-size:13px;font-weight:600;padding:8px 16px;border-radius:8px;text-decoration:none;" id="manage-subscription-btn">View Invoices</a>
            </div>

            <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:18px;">
                <div style="font-size:13px;font-weight:700;color:#111827;margin-bottom:12px;">Workspace Role</div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:12.5px;color:#6b7280;">Current Role</span>
                        <span style="font-size:12.5px;font-weight:600;color:#1d4ed8;">{{ $userRole }}</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:12.5px;color:#6b7280;">Projects</span>
                        <span style="font-size:12.5px;font-weight:600;color:#111827;">{{ $user->projects()->count() }}</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:12.5px;color:#6b7280;">Tasks Assigned</span>
                        <span style="font-size:12.5px;font-weight:600;color:#111827;">{{ $user->assignedTasks()->count() }}</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:12.5px;color:#6b7280;">Member Since</span>
                        <span style="font-size:12.5px;font-weight:600;color:#111827;">{{ $user->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>[x-cloak]{display:none!important}</style>
</x-app-layout>
