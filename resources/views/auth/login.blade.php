<x-guest-layout>
    @section('title', 'Sign In')

    <!-- Session Status -->
    @if (session('status'))
        <div class="session-status">{{ session('status') }}</div>
    @endif

    <h2 class="guest-form-title">Welcome back</h2>
    <p class="guest-form-subtitle">Sign in to manage your sprints and tasks.</p>

    <form method="POST" action="{{ route('login') }}" id="login-form">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label class="form-label" for="email">Email address</label>
            <div class="form-input-wrap">
                <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="name@company.com"
                    required autofocus autocomplete="username"
                    class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                >
            </div>
            @error('email')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:5px;">
                <label class="form-label" for="password" style="margin:0;">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                @endif
            </div>
            <div class="form-input-wrap">
                <svg class="form-input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                <input
                    id="password"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required autocomplete="current-password"
                    class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                >
                <button type="button" class="toggle-pw" onclick="togglePw('password', this)" tabindex="-1">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </button>
            </div>
            @error('password')
                <div class="form-error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="checkbox-row">
            <label class="checkbox-label" for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                Keep me signed in
            </label>
        </div>

        <button type="submit" class="btn-full" id="sign-in-btn">Sign In</button>

        <div class="switch-link">
            Don't have account? <a href="{{ route('register') }}">Sign up</a>
        </div>
    </form>

    <script>
        function togglePw(id, btn) {
            const inp = document.getElementById(id);
            inp.type = inp.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>
