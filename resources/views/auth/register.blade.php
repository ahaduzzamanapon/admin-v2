@extends('layouts.shop')

@section('title', 'Create Account')

@section('content')
    <div style="min-height: 80vh; display:flex; align-items:center; justify-content:center; padding: 40px 20px;">
        <div style="width: 100%; max-width: 480px;">
            <div style="text-align:center; margin-bottom:32px;">
                <h1 style="font-size:1.8rem; font-weight:800; margin-bottom:8px;">Create Account</h1>
                <p style="color:var(--text-muted);">Join us and start shopping</p>
            </div>

            @if($errors->any())
                <div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif

            <div class="card" style="padding:32px;">
                {{-- Social Register --}}
                <a href="{{ route('socialite.redirect', 'google') }}"
                    style="display:flex; align-items:center; justify-content:center; gap:10px; padding:12px; border:1.5px solid var(--border); border-radius:var(--radius-sm); font-weight:600; margin-bottom:10px; transition:var(--transition);"
                    onmouseover="this.style.borderColor='#4285f4'" onmouseout="this.style.borderColor='var(--border)'">
                    <svg width="18" height="18" viewBox="0 0 18 18">
                        <path fill="#EA4335"
                            d="M9 3.48c1.69 0 2.83.73 3.48 1.34l2.54-2.48C13.46.89 11.43 0 9 0 5.48 0 2.44 2.02.96 4.96l2.91 2.26C4.6 5.05 6.62 3.48 9 3.48z" />
                        <path fill="#FBBC05"
                            d="M17.64 9.2c0-.74-.06-1.28-.19-1.84H9v3.34h4.96c-.1.83-.65 2.08-1.88 2.92l2.88 2.23c1.72-1.59 2.68-3.93 2.68-6.65z" />
                        <path fill="#34A853"
                            d="M3.88 10.78A5.54 5.54 0 0 1 3.58 9c0-.62.11-1.22.29-1.78L.96 4.96A9 9 0 0 0 0 9c0 1.45.35 2.82.96 4.04l2.92-2.26z" />
                        <path fill="#4285F4"
                            d="M9 18c2.43 0 4.47-.8 5.96-2.18l-2.88-2.23c-.77.53-1.8.9-3.08.9-2.38 0-4.4-1.57-5.12-3.74L.97 13.04C2.45 15.98 5.48 18 9 18z" />
                    </svg>
                    Sign up with Google
                </a>
                <a href="{{ route('socialite.redirect', 'github') }}"
                    style="display:flex; align-items:center; justify-content:center; gap:10px; padding:12px; border:1.5px solid var(--border); border-radius:var(--radius-sm); font-weight:600; margin-bottom:24px; background:#0d1117; color:#fff; transition:var(--transition);">
                    <i class="fa-brands fa-github" style="font-size:1.1rem;"></i>
                    Sign up with GitHub
                </a>

                <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px;">
                    <div style="flex:1; height:1px; background:var(--border);"></div>
                    <span style="font-size:.8rem; color:var(--text-light);">or register with email</span>
                    <div style="flex:1; height:1px; background:var(--border);"></div>
                </div>

                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required
                            placeholder="John Doe">
                        @error('name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required
                            placeholder="you@example.com">
                        @error('email')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone (Optional)</label>
                        <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}"
                            placeholder="01XXXXXXXXX">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required
                            placeholder="At least 8 characters" minlength="8">
                        @error('password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required
                            placeholder="Repeat password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Create Account</button>
                </form>
            </div>

            <p style="text-align:center; margin-top:20px; font-size:.9rem; color:var(--text-muted);">
                Already have an account? <a href="{{ route('login') }}" style="color:var(--primary); font-weight:600;">Sign
                    in</a>
            </p>
        </div>
    </div>
@endsection