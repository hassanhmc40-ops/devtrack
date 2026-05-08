<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevTrack — Project Management Simplified</title>
    <meta name="description" content="DevTrack is a next-generation task orchestration platform for agile engineering teams. Real-time visibility, structured backlogs, seamless collaboration.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #0f172a; min-height: 100vh; overflow-x: hidden; }

        /* ── Animated background ── */
        .bg-grid {
            position: fixed; inset: 0; z-index: 0;
            background-image:
                linear-gradient(rgba(29,78,216,.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(29,78,216,.06) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .bg-glow {
            position: fixed; z-index: 0;
            border-radius: 50%; filter: blur(120px); pointer-events: none;
        }
        .bg-glow-1 { width: 600px; height: 600px; background: rgba(29,78,216,.18); top: -200px; right: -100px; }
        .bg-glow-2 { width: 400px; height: 400px; background: rgba(124,58,237,.12); bottom: -100px; left: -100px; }

        /* ── Navbar ── */
        .nav {
            position: relative; z-index: 10;
            display: flex; align-items: center; justify-content: space-between;
            padding: 20px 60px;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .nav-logo {
            display: flex; align-items: center; gap: 10px;
            font-size: 18px; font-weight: 700; color: #fff; text-decoration: none;
        }
        .nav-logo-icon {
            width: 34px; height: 34px; background: rgba(29,78,216,.6);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            border: 1px solid rgba(29,78,216,.4);
        }
        .nav-actions { display: flex; align-items: center; gap: 12px; }
        .nav-link { font-size: 14px; color: rgba(255,255,255,.65); text-decoration: none; padding: 6px 12px; border-radius: 7px; transition: all .15s; }
        .nav-link:hover { color: #fff; background: rgba(255,255,255,.06); }
        .nav-btn {
            background: #1d4ed8; color: #fff; font-size: 14px; font-weight: 600;
            padding: 8px 20px; border-radius: 8px; text-decoration: none;
            transition: background .15s;
        }
        .nav-btn:hover { background: #1e40af; }

        /* ── Hero ── */
        .hero {
            position: relative; z-index: 5;
            display: flex;
            min-height: calc(100vh - 73px);
        }

        /* Left Content */
        .hero-left {
            flex: 1; display: flex; flex-direction: column;
            justify-content: center; padding: 80px 60px;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 7px;
            background: rgba(29,78,216,.2); border: 1px solid rgba(29,78,216,.4);
            color: #93c5fd; font-size: 12px; font-weight: 600;
            padding: 5px 14px; border-radius: 20px;
            margin-bottom: 28px; letter-spacing: .3px;
        }
        .hero-badge span { width: 6px; height: 6px; border-radius: 50%; background: #3b82f6; display: inline-block; animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.6;transform:scale(1.2)} }

        .hero-title {
            font-size: 52px; font-weight: 800; color: #fff;
            line-height: 1.15; margin-bottom: 20px; max-width: 520px;
            letter-spacing: -1px;
        }
        .hero-title .accent { color: #3b82f6; }
        .hero-subtitle {
            font-size: 17px; color: rgba(255,255,255,.55);
            margin-bottom: 40px; max-width: 440px; line-height: 1.7;
        }
        .hero-cta { display: flex; align-items: center; gap: 12px; margin-bottom: 50px; }
        .cta-primary {
            background: #1d4ed8; color: #fff; font-size: 15px; font-weight: 600;
            padding: 13px 28px; border-radius: 10px; text-decoration: none;
            display: flex; align-items: center; gap: 8px;
            box-shadow: 0 4px 24px rgba(29,78,216,.4);
            transition: all .2s;
        }
        .cta-primary:hover { background: #1e40af; transform: translateY(-1px); box-shadow: 0 6px 30px rgba(29,78,216,.5); }
        .cta-secondary {
            color: rgba(255,255,255,.75); font-size: 15px; font-weight: 500;
            padding: 13px 24px; border-radius: 10px; text-decoration: none;
            border: 1px solid rgba(255,255,255,.12);
            transition: all .15s;
        }
        .cta-secondary:hover { color: #fff; border-color: rgba(255,255,255,.3); background: rgba(255,255,255,.05); }

        .hero-features { display: flex; flex-direction: column; gap: 14px; }
        .hero-feature {
            display: flex; align-items: center; gap: 10px;
            font-size: 14px; color: rgba(255,255,255,.6);
        }
        .hero-feature-check {
            width: 20px; height: 20px; border-radius: 50%;
            background: rgba(34,197,94,.15); border: 1px solid rgba(34,197,94,.3);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        /* Right Visual */
        .hero-right {
            width: 520px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            padding: 60px 60px 60px 0;
        }
        .dashboard-preview {
            background: #1e293b; border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px; overflow: hidden;
            box-shadow: 0 24px 80px rgba(0,0,0,.5), 0 0 0 1px rgba(255,255,255,.04);
            width: 100%;
        }
        .preview-topbar {
            background: #0f172a; padding: 12px 16px;
            display: flex; align-items: center; gap: 8px;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .preview-dot { width: 10px; height: 10px; border-radius: 50%; }
        .preview-title { font-size: 12px; color: rgba(255,255,255,.4); margin-left: 8px; }
        .preview-body { padding: 16px; }
        .preview-stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; margin-bottom: 14px; }
        .preview-stat {
            background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.06);
            border-radius: 8px; padding: 10px 12px;
        }
        .preview-stat-val { font-size: 18px; font-weight: 700; color: #fff; }
        .preview-stat-lbl { font-size: 10px; color: rgba(255,255,255,.4); margin-top: 1px; }
        .preview-kanban { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; }
        .preview-col-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 8px; }
        .preview-card {
            background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.06);
            border-radius: 6px; padding: 8px 10px; margin-bottom: 6px;
        }
        .preview-card-title { font-size: 10px; font-weight: 600; color: rgba(255,255,255,.8); margin-bottom: 4px; }
        .preview-card-badge { display: inline-block; font-size: 9px; font-weight: 700; padding: 1px 6px; border-radius: 10px; }

        /* ── Stats Section ── */
        .stats-bar {
            position: relative; z-index: 5;
            display: flex; align-items: center; justify-content: center; gap: 60px;
            padding: 32px 60px;
            border-top: 1px solid rgba(255,255,255,.06);
            border-bottom: 1px solid rgba(255,255,255,.06);
            background: rgba(255,255,255,.02);
        }
        .stat-item { text-align: center; }
        .stat-number { font-size: 28px; font-weight: 800; color: #fff; }
        .stat-label { font-size: 13px; color: rgba(255,255,255,.45); margin-top: 2px; }

        @media (max-width: 1024px) {
            .hero-right { display: none; }
            .hero-title { font-size: 38px; }
            .nav { padding: 18px 24px; }
            .hero-left { padding: 60px 24px; }
        }
    </style>
</head>
<body>
    <div class="bg-grid"></div>
    <div class="bg-glow bg-glow-1"></div>
    <div class="bg-glow bg-glow-2"></div>

    <!-- Navbar -->
    <nav class="nav">
        <a href="{{ route('home') }}" class="nav-logo">
            <div class="nav-logo-icon">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            DevTrack
        </a>
        <div class="nav-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="nav-link">Sign In</a>
                <a href="{{ route('register') }}" class="nav-btn">Get Started Free</a>
            @endauth
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-left">
            <div class="hero-badge">
                <span></span>
                Next-gen project orchestration
            </div>

            <h1 class="hero-title">
                terminal <span class="accent">DevTrack</span><br>
                Project management<br>simplified.
            </h1>
            <p class="hero-subtitle">
                Accelerate your engineering workflow with systematic precision.
                Real-time sprints, structured backlogs, seamless team collaboration.
            </p>

            <div class="hero-cta">
                @auth
                    <a href="{{ route('dashboard') }}" class="cta-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="cta-primary" id="welcome-get-started">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Get Started Free
                    </a>
                    <a href="{{ route('login') }}" class="cta-secondary" id="welcome-sign-in">Sign In</a>
                @endauth
            </div>

            <div class="hero-features">
                @foreach ([
                    'Real-time collaboration across your entire team',
                    'Role-based access controls (Lead / Developer)',
                    'Automated sprint tracking with deadline alerts',
                    'Developer-first task management workflow',
                ] as $feature)
                <div class="hero-feature">
                    <div class="hero-feature-check">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#22c55e" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    {{ $feature }}
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right: Dashboard Preview -->
        <div class="hero-right">
            <div class="dashboard-preview">
                <div class="preview-topbar">
                    <div class="preview-dot" style="background:#ef4444;"></div>
                    <div class="preview-dot" style="background:#f59e0b;"></div>
                    <div class="preview-dot" style="background:#22c55e;"></div>
                    <span class="preview-title">devtrack.app/dashboard</span>
                </div>
                <div class="preview-body">
                    <div style="font-size:13px;font-weight:700;color:rgba(255,255,255,.85);margin-bottom:12px;">My Projects</div>
                    <div class="preview-stats">
                        <div class="preview-stat">
                            <div class="preview-stat-val">124</div>
                            <div class="preview-stat-lbl">Total Tasks</div>
                        </div>
                        <div class="preview-stat">
                            <div class="preview-stat-val" style="color:#22c55e;">78</div>
                            <div class="preview-stat-lbl">Completed</div>
                        </div>
                        <div class="preview-stat">
                            <div class="preview-stat-val" style="color:#ef4444;">4</div>
                            <div class="preview-stat-lbl">Overdue</div>
                        </div>
                    </div>
                    <div style="font-size:10px;font-weight:700;color:rgba(255,255,255,.4);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">Active Sprint — Kanban</div>
                    <div class="preview-kanban">
                        <div>
                            <div class="preview-col-title" style="color:rgba(255,255,255,.4);">TO DO · 3</div>
                            @foreach (['Auth Refactor', 'UI Library', 'SEO Fix'] as $t)
                            <div class="preview-card">
                                <div class="preview-card-title">{{ $t }}</div>
                                <span class="preview-card-badge" style="background:rgba(239,68,68,.15);color:#f87171;">HIGH</span>
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <div class="preview-col-title" style="color:#3b82f6;">IN PROGRESS · 2</div>
                            @foreach (['DB Migration', 'API Docs'] as $t)
                            <div class="preview-card" style="border-color:rgba(59,130,246,.2);">
                                <div class="preview-card-title">{{ $t }}</div>
                                <span class="preview-card-badge" style="background:rgba(59,130,246,.15);color:#60a5fa;">ACTIVE</span>
                            </div>
                            @endforeach
                        </div>
                        <div>
                            <div class="preview-col-title" style="color:#22c55e;">DONE · 5</div>
                            @foreach (['Landing Page', 'Payments'] as $t)
                            <div class="preview-card" style="opacity:.6;">
                                <div class="preview-card-title">{{ $t }}</div>
                                <span class="preview-card-badge" style="background:rgba(34,197,94,.15);color:#4ade80;">DONE</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <div class="stats-bar">
        @foreach ([
            ['10k+', 'Tasks Managed'],
            ['500+', 'Engineering Teams'],
            ['99.9%', 'Uptime SLA'],
            ['4.9★', 'User Rating'],
        ] as $stat)
        <div class="stat-item">
            <div class="stat-number">{{ $stat[0] }}</div>
            <div class="stat-label">{{ $stat[1] }}</div>
        </div>
        @endforeach
    </div>
</body>
</html>
