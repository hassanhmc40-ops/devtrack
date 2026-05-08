<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DevTrack') }} — @yield('title', 'Welcome')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

        body { margin: 0; background: #f9fafb; }

        .guest-wrapper {
            display: flex; min-height: 100vh;
        }

        /* ── Left Panel ── */
        .guest-left {
            flex: 1;
            background: linear-gradient(145deg, #0f172a 0%, #1e3a6e 60%, #1d4ed8 100%);
            display: flex; flex-direction: column;
            justify-content: center; padding: 60px;
            position: relative; overflow: hidden;
        }
        .guest-left::before {
            content: '';
            position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .guest-brand {
            display: flex; align-items: center; gap: 10px;
            font-size: 20px; font-weight: 700; color: #fff;
            margin-bottom: 40px; position: relative;
        }
        .guest-brand-icon {
            width: 36px; height: 36px; background: rgba(255,255,255,.15);
            border-radius: 9px; display: flex; align-items: center; justify-content: center;
        }
        .guest-headline {
            font-size: 30px; font-weight: 800; color: #fff;
            line-height: 1.25; margin-bottom: 16px; position: relative;
            max-width: 380px;
        }
        .guest-headline span { color: #60a5fa; }
        .guest-tagline {
            font-size: 14.5px; color: rgba(255,255,255,.65);
            margin-bottom: 44px; position: relative; max-width: 360px;
            line-height: 1.6;
        }
        .guest-features { list-style: none; padding: 0; margin: 0; position: relative; }
        .guest-features li {
            display: flex; align-items: flex-start; gap: 12px;
            margin-bottom: 18px;
        }
        .guest-feature-icon {
            width: 32px; height: 32px; border-radius: 8px;
            background: rgba(255,255,255,.1);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; margin-top: 1px;
        }
        .guest-feature-text strong {
            display: block; font-size: 13.5px; color: #fff; font-weight: 600;
        }
        .guest-feature-text span {
            font-size: 12.5px; color: rgba(255,255,255,.55); line-height: 1.5;
        }

        /* ── Right Panel ── */
        .guest-right {
            width: 480px; min-width: 480px;
            background: #fff;
            display: flex; flex-direction: column;
            justify-content: space-between;
            padding: 0;
        }
        .guest-form-wrap {
            flex: 1; display: flex; flex-direction: column;
            justify-content: center; padding: 48px 48px 32px;
        }
        .guest-form-title {
            font-size: 22px; font-weight: 700; color: #111827; margin-bottom: 4px;
        }
        .guest-form-subtitle {
            font-size: 13.5px; color: #6b7280; margin-bottom: 28px;
        }

        /* ── Form ── */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 5px; }
        .form-input-wrap { position: relative; }
        .form-input-icon {
            position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; width: 16px; height: 16px;
        }
        .form-input {
            width: 100%; padding: 10px 12px 10px 38px;
            border: 1px solid #e5e7eb; border-radius: 8px;
            font-size: 13.5px; color: #111827;
            background: #fff; outline: none;
            transition: border-color .15s;
            box-sizing: border-box;
        }
        .form-input:focus { border-color: #1d4ed8; box-shadow: 0 0 0 3px rgba(29,78,216,.08); }
        .form-input.no-icon { padding-left: 12px; }
        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; }
        .form-input.is-invalid { border-color: #ef4444; }
        .toggle-pw {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; cursor: pointer; background: none; border: none; padding: 0;
        }

        .checkbox-row {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px;
        }
        .checkbox-label {
            display: flex; align-items: center; gap: 7px;
            font-size: 13px; color: #374151; cursor: pointer;
        }
        .checkbox-label input { accent-color: #1d4ed8; }
        .forgot-link {
            font-size: 13px; color: #1d4ed8; text-decoration: none; font-weight: 500;
        }
        .forgot-link:hover { text-decoration: underline; }

        .btn-full {
            width: 100%; background: #1d4ed8; color: #fff;
            padding: 11px; border-radius: 8px;
            font-size: 14px; font-weight: 600;
            border: none; cursor: pointer; transition: background .15s;
            margin-bottom: 18px;
        }
        .btn-full:hover { background: #1e40af; }

        .divider {
            display: flex; align-items: center; gap: 12px;
            font-size: 12px; color: #9ca3af; margin-bottom: 14px;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: #e5e7eb;
        }

        .oauth-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 24px; }
        .oauth-btn {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 9px; border: 1px solid #e5e7eb; border-radius: 8px;
            font-size: 13px; font-weight: 500; color: #374151;
            background: #fff; cursor: pointer; transition: background .15s; text-decoration: none;
        }
        .oauth-btn:hover { background: #f9fafb; }

        .switch-link {
            text-align: center; font-size: 13px; color: #6b7280;
        }
        .switch-link a { color: #1d4ed8; text-decoration: none; font-weight: 600; }
        .switch-link a:hover { text-decoration: underline; }

        .guest-footer {
            padding: 16px 48px;
            border-top: 1px solid #f3f4f6;
            display: flex; align-items: center; justify-content: space-between;
            font-size: 11.5px; color: #9ca3af;
        }
        .guest-footer a { color: #9ca3af; text-decoration: none; }
        .guest-footer a:hover { color: #374151; }
        .guest-footer-links { display: flex; gap: 16px; }

        .terms-row {
            display: flex; align-items: flex-start; gap: 7px;
            font-size: 12.5px; color: #6b7280; margin-bottom: 18px;
        }
        .terms-row input { margin-top: 2px; accent-color: #1d4ed8; flex-shrink: 0; }
        .terms-row a { color: #1d4ed8; text-decoration: none; }
        .terms-row a:hover { text-decoration: underline; }

        .session-status {
            background: #ecfdf5; border: 1px solid #6ee7b7;
            color: #065f46; padding: 10px 14px; border-radius: 8px;
            font-size: 13px; margin-bottom: 16px;
        }

        @media (max-width: 900px) {
            .guest-left { display: none; }
            .guest-right { width: 100%; min-width: 0; }
        }
    </style>
</head>
<body>
<div class="guest-wrapper">

    <!-- Left decorative panel -->
    <div class="guest-left">
        <div class="guest-brand">
            <div class="guest-brand-icon">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            DevTrack
        </div>

        <h1 class="guest-headline">
            Accelerate your development workflow with <span>systematic precision.</span>
        </h1>
        <p class="guest-tagline">Next-generation task orchestration for agile engineering teams.</p>

        <ul class="guest-features">
            <li>
                <div class="guest-feature-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </div>
                <div class="guest-feature-text">
                    <strong>Real-time Visibility</strong>
                    <span>Monitor sprint progress and team velocity with high-fidelity interactive dashboards.</span>
                </div>
            </li>
            <li>
                <div class="guest-feature-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                </div>
                <div class="guest-feature-text">
                    <strong>Structured Backlogs</strong>
                    <span>Organize complex requirements into manageable tasks with full audit trails.</span>
                </div>
            </li>
            <li>
                <div class="guest-feature-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                </div>
                <div class="guest-feature-text">
                    <strong>Seamless Collaboration</strong>
                    <span>Connect your engineering team through shared context and automated notifications.</span>
                </div>
            </li>
        </ul>
    </div>

    <!-- Right form panel -->
    <div class="guest-right">
        <div class="guest-form-wrap">
            {{ $slot }}
        </div>

        <div class="guest-footer">
            <span>DevTrack v0.4.1</span>
            <div class="guest-footer-links">
                <a href="#">Help Center</a>
                <a href="#">Contact Support</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
