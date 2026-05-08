<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DevTrack') }} — @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Inter', sans-serif; }

        /* ── Sidebar ── */
        .sidebar {
            width: 220px; min-width: 220px;
            background: #fff;
            border-right: 1px solid #e5e7eb;
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 40;
        }
        .sidebar-logo {
            padding: 20px 20px 16px;
            font-size: 17px; font-weight: 700;
            color: #1d4ed8;
            border-bottom: 1px solid #e5e7eb;
            display: flex; align-items: center; gap: 8px;
            letter-spacing: -0.3px;
        }
        .sidebar-logo span { color: #111827; }
        .sidebar-nav { padding: 12px 10px; flex: 1; overflow-y: auto; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 8px;
            font-size: 13.5px; font-weight: 500;
            color: #6b7280; text-decoration: none;
            transition: all .15s;
            margin-bottom: 2px;
        }
        .sidebar-nav a:hover { background: #f3f4f6; color: #111827; }
        .sidebar-nav a.active { background: #eff6ff; color: #1d4ed8; font-weight: 600; }
        .sidebar-nav a svg { width: 16px; height: 16px; flex-shrink: 0; }
        .sidebar-user {
            padding: 14px 16px;
            border-top: 1px solid #e5e7eb;
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-avatar {
            width: 34px; height: 34px; border-radius: 50%;
            background: linear-gradient(135deg,#1d4ed8,#3b82f6);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .sidebar-user-info { flex: 1; min-width: 0; }
        .sidebar-user-name { font-size: 13px; font-weight: 600; color: #111827; truncate; }
        .sidebar-user-role { font-size: 11px; color: #6b7280; }

        /* ── Top Bar ── */
        .topbar {
            height: 58px; background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex; align-items: center;
            padding: 0 24px; gap: 12px;
            position: fixed; top: 0; left: 220px; right: 0; z-index: 30;
        }
        .topbar-title {
            font-size: 15px; font-weight: 600;
            color: #111827; flex: 1;
        }
        .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .icon-btn {
            width: 34px; height: 34px; border-radius: 8px;
            border: 1px solid #e5e7eb; background: #fff;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: #6b7280;
            transition: all .15s;
        }
        .icon-btn:hover { background: #f3f4f6; color: #111827; }

        /* ── Main Content ── */
        .main-content {
            margin-left: 220px;
            padding-top: 58px;
            min-height: 100vh;
            background: #f9fafb;
        }
        .page-body { padding: 28px; }

        /* ── Flash Messages ── */
        .flash-success {
            background: #ecfdf5; border: 1px solid #6ee7b7;
            color: #065f46; padding: 10px 16px; border-radius: 8px;
            font-size: 13.5px; margin-bottom: 18px;
            display: flex; align-items: center; gap: 8px;
        }
        .flash-error {
            background: #fef2f2; border: 1px solid #fca5a5;
            color: #991b1b; padding: 10px 16px; border-radius: 8px;
            font-size: 13.5px; margin-bottom: 18px;
        }

        /* ── Breadcrumb ── */
        .breadcrumb {
            display: flex; align-items: center; gap: 6px;
            font-size: 12.5px; color: #6b7280; margin-bottom: 4px;
        }
        .breadcrumb a { color: #6b7280; text-decoration: none; }
        .breadcrumb a:hover { color: #1d4ed8; }
        .breadcrumb-sep { color: #d1d5db; }

        /* ── Buttons ── */
        .btn-primary {
            background: #1d4ed8; color: #fff;
            padding: 8px 16px; border-radius: 8px;
            font-size: 13.5px; font-weight: 500;
            border: none; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none; transition: background .15s;
        }
        .btn-primary:hover { background: #1e40af; color: #fff; }
        .btn-secondary {
            background: #fff; color: #374151;
            padding: 8px 16px; border-radius: 8px;
            font-size: 13.5px; font-weight: 500;
            border: 1px solid #e5e7eb; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none; transition: all .15s;
        }
        .btn-secondary:hover { background: #f3f4f6; }
        .btn-danger {
            background: #dc2626; color: #fff;
            padding: 8px 16px; border-radius: 8px;
            font-size: 13.5px; font-weight: 500;
            border: none; cursor: pointer;
            display: inline-flex; align-items: center; gap: 6px;
            text-decoration: none; transition: background .15s;
        }
        .btn-danger:hover { background: #b91c1c; color: #fff; }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,.45);
            z-index: 100; display: flex; align-items: center; justify-content: center;
            padding: 24px;
        }
        .modal-box {
            background: #fff; border-radius: 14px;
            width: 100%; max-width: 520px;
            box-shadow: 0 20px 60px rgba(0,0,0,.15);
            overflow: hidden;
        }
        .modal-header {
            padding: 20px 24px 0;
            display: flex; align-items: center; justify-content: space-between;
        }
        .modal-title { font-size: 16px; font-weight: 700; color: #111827; }
        .modal-close {
            width: 28px; height: 28px; border-radius: 6px;
            border: 1px solid #e5e7eb; background: #fff;
            cursor: pointer; color: #6b7280;
            display: flex; align-items: center; justify-content: center;
        }
        .modal-body { padding: 20px 24px; }
        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #f3f4f6;
            display: flex; align-items: center; justify-content: flex-end; gap: 10px;
        }

        /* ── Form Elements ── */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 5px; }
        .form-input {
            width: 100%; padding: 9px 12px;
            border: 1px solid #d1d5db; border-radius: 8px;
            font-size: 13.5px; color: #111827;
            background: #fff; outline: none;
            transition: border-color .15s;
            box-sizing: border-box;
        }
        .form-input:focus { border-color: #1d4ed8; box-shadow: 0 0 0 3px rgba(29,78,216,.08); }
        .form-input.is-invalid { border-color: #ef4444; }
        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        select.form-input { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 8px center; background-size: 16px; padding-right: 32px; }
        textarea.form-input { resize: vertical; min-height: 80px; }

        /* ── Status & Priority Badges ── */
        .badge {
            display: inline-flex; align-items: center;
            padding: 2px 8px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600; letter-spacing: .2px;
        }
        .badge-todo { background: #f3f4f6; color: #374151; }
        .badge-inprogress { background: #dbeafe; color: #1d4ed8; }
        .badge-done { background: #dcfce7; color: #15803d; }
        .badge-high { background: #fee2e2; color: #dc2626; }
        .badge-medium { background: #fef3c7; color: #d97706; }
        .badge-low { background: #f0fdf4; color: #16a34a; }
        .badge-overdue { background: #fee2e2; color: #dc2626; }
        .badge-urgent { background: #fef3c7; color: #d97706; }

        /* ── Delete Confirm Modal ── */
        .delete-modal-icon {
            width: 52px; height: 52px; border-radius: 50%;
            background: #fee2e2; color: #dc2626;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px; font-size: 24px;
        }
    </style>
</head>
<body style="background:#f9fafb;">

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-logo">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        <span style="color:#1d4ed8;">Dev</span><span>Track</span>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>
        <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.index') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
            All Projects
        </a>
        <a href="{{ route('analytics') }}" class="{{ request()->routeIs('analytics') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            Analytics
        </a>
        <a href="{{ route('projects.archives') }}" class="{{ request()->routeIs('projects.archives') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
            Archive
        </a>
    </nav>

    <div class="sidebar-user">
        <div class="sidebar-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="sidebar-user-info">
            <div class="sidebar-user-name" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Auth::user()->name }}</div>
            @php
                $userRole = 'Member';
                if (isset($project)) {
                    $pivot = $project->users->where('id', Auth::id())->first()?->pivot;
                    $userRole = $pivot ? ucfirst($pivot->role) : 'Member';
                }
            @endphp
            <div class="sidebar-user-role">{{ $userRole }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" title="Logout" style="background:none;border:none;cursor:pointer;color:#9ca3af;padding:4px;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </button>
        </form>
    </div>
</aside>

<!-- Top Bar -->
<div class="topbar">
    <div class="topbar-title">@yield('topbar-title', config('app.name', 'DevTrack'))</div>
    <div class="topbar-actions">
        @yield('topbar-actions')
        <div class="icon-btn" title="Notifications">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
        </div>
        <a href="{{ route('profile.edit') }}" class="icon-btn" title="Settings">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
        </a>
        <div class="sidebar-avatar" style="width:32px;height:32px;font-size:12px;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="page-body">
        @if (session('success'))
            <div class="flash-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="flash-error">{{ session('error') }}</div>
        @endif
        @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
            <div class="flash-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{ $slot }}
    </div>
</div>

</body>
</html>
