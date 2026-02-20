@extends('layouts.account')

@section('title', 'My Profile')

@section('account-content')
    <h1 style="font-size:1.6rem; font-weight:800; margin-bottom:24px;">My Profile</h1>

    @if(session('success'))
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    {{-- Profile Info --}}
    <div class="card" style="padding:28px; margin-bottom:20px;">
        <h3 style="font-size:1rem; font-weight:700; margin-bottom:20px;">Personal Information</h3>
        <form action="{{ route('account.profile.update') }}" method="POST">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}"
                        placeholder="01XXXXXXXXX">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" value="{{ $user->email }}" disabled
                    style="background:var(--surface-3); color:var(--text-muted);">
                <div style="font-size:.75rem; color:var(--text-light); margin-top:4px;">Email cannot be changed.</div>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    {{-- Change Password (only for email users) --}}
    @if(!$user->provider)
        <div class="card" style="padding:28px;">
            <h3 style="font-size:1rem; font-weight:700; margin-bottom:20px;">Change Password</h3>
            <form action="{{ route('account.password.change') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required placeholder="••••••••">
                    @error('current_password')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" required placeholder="At least 8 characters"
                            minlength="8">
                        @error('password')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required
                            placeholder="Repeat password">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>
    @else
        <div class="card" style="padding:24px;">
            <div style="display:flex; align-items:center; gap:12px; color:var(--text-muted);">
                <i class="fa {{ $user->provider === 'google' ? 'fa-google text-[#4285f4]' : 'fa-github' }}"
                    style="font-size:1.2rem;"></i>
                <span>You signed in with <strong>{{ ucfirst($user->provider) }}</strong>. Password management is not available
                    for social accounts.</span>
            </div>
        </div>
    @endif
@endsection