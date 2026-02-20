@extends('layouts.shop')

@section('title', 'My Account')

@section('content')
    <div class="container" style="padding: 40px 20px;">
        <div style="display:grid; grid-template-columns: 240px 1fr; gap:28px; align-items:start;">

            {{-- Account Sidebar --}}
            <aside class="card" style="padding:20px; position:sticky; top:80px;">
                <div
                    style="display:flex; align-items:center; gap:12px; margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid var(--border);">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}"
                            style="width:44px;height:44px;border-radius:50%;object-fit:cover;" alt="">
                    @else
                        <div
                            style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-dark));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:1.1rem;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div style="font-weight:700; font-size:.9rem;">{{ auth()->user()->name }}</div>
                        <div style="font-size:.75rem; color:var(--text-muted);">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <ul style="list-style:none; display:flex; flex-direction:column; gap:4px;">
                    @foreach([
                            ['account.dashboard', 'fa-house', 'Dashboard'],
                            ['account.orders', 'fa-box', 'My Orders'],
                            ['account.profile', 'fa-user', 'Profile'],
                        ] as [$route, $icon, $label])
                        <li>
                            <a href="{{ route($route) }}" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:var(--radius-sm);font-size:.9rem;font-weight:500;color:{{ request()->routeIs($route) ? 'var(--primary)' : 'var(--text)' }};background:{{ request()->routeIs($route) ? 'rgb(99 102 241 / .08)' : 'transparent' }};transition:var(--transition);">
                                <i class="fa {{ $icon }}" style="width:16px;text-align:center;"></i> {{ $label }}
                            </a>
                        </li>
                    @endforeach

                                               <li style="margin-top:8px; padding-top:8px; border-top:1px solid var(--border);">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:var(--radius-sm);font-size:.9rem;font-weight:500;color:var(--danger);background:transparent;border:none;cursor:pointer;width:100%;transition:var(--transition);">
                                <i class="fa fa-right-from-bracket" style="width:16px;text-align:center;"></i> Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </aside>

            {{-- Main Content --}}
            <div>
                @yield('account-content')
            </div>
        </div>
    </div>
@endsection
