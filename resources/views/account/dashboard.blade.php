@extends('layouts.account')

@section('title', 'Dashboard')

@section('account-content')
<h1 style="font-size:1.6rem; font-weight:800; margin-bottom:24px;">Dashboard</h1>

{{-- Stats --}}
<div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; margin-bottom:28px;">
    @foreach([
        [$totalOrders, 'fa-box', 'Total Orders', 'var(--primary)'],
        [$delivered, 'fa-check-circle', 'Delivered', '#10b981'],
        [$pending, 'fa-clock', 'Pending', '#f59e0b'],
    ] as [$val, $icon, $label, $color])
    <div class="card" style="padding:20px; display:flex; gap:16px; align-items:center;">
        <div style="width:48px;height:48px;border-radius:var(--radius);background:{{ $color }}20;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:{{ $color }};">
            <i class="fa {{ $icon }}"></i>
        </div>
        <div>
            <div style="font-size:1.6rem;font-weight:800;">{{ $val }}</div>
            <div style="font-size:.8rem;color:var(--text-muted);">{{ $label }}</div>
        </div>
    </div>
    @endforeach
</div>

{{-- Recent Orders --}}
<div class="card" style="overflow:hidden;">
    <div style="padding:20px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between;">
        <h3 style="font-weight:700;">Recent Orders</h3>
        <a href="{{ route('account.orders') }}" class="view-all">View All <i class="fa fa-arrow-right"></i></a>
    </div>
    @if($recentOrders->isEmpty())
    <div style="padding:40px; text-align:center; color:var(--text-muted);">
        <i class="fa fa-box-open" style="font-size:2rem; margin-bottom:12px; display:block;"></i>
        No orders yet.
    </div>
    @else
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:var(--surface-2);">
                <th style="padding:12px 24px; text-align:left; font-size:.8rem; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:var(--text-muted);">Order</th>
                <th style="padding:12px 16px; text-align:left; font-size:.8rem; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:var(--text-muted);">Date</th>
                <th style="padding:12px 16px; text-align:left; font-size:.8rem; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:var(--text-muted);">Status</th>
                <th style="padding:12px 24px; text-align:right; font-size:.8rem; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:var(--text-muted);">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
            <tr style="border-top:1px solid var(--border); transition:var(--transition);" onmouseover="this.style.background='var(--surface-2)'" onmouseout="this.style.background=''">
                <td style="padding:14px 24px;">
                    <a href="{{ route('account.order.show', $order->order_number) }}" style="font-weight:600; color:var(--primary);">{{ $order->order_number }}</a>
                </td>
                <td style="padding:14px 16px; font-size:.875rem; color:var(--text-muted);">{{ $order->created_at->format('M d, Y') }}</td>
                <td style="padding:14px 16px;"><span class="badge badge-{{ $order->status }}">{{ $order->statusLabel }}</span></td>
                <td style="padding:14px 24px; text-align:right; font-weight:700;">৳{{ number_format($order->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
