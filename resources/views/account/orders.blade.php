@extends('layouts.account')

@section('title', 'My Orders')

@section('account-content')
    <h1 style="font-size:1.6rem; font-weight:800; margin-bottom:24px;">My Orders</h1>

    @if($orders->isEmpty())
        <div class="card" style="padding:48px; text-align:center;">
            <i class="fa fa-box-open" style="font-size:3rem; color:var(--text-light); margin-bottom:16px; display:block;"></i>
            <h3 style="color:var(--text-muted);">No orders yet</h3>
            <a href="{{ route('home') }}" class="btn btn-primary" style="display:inline-flex; margin-top:20px;">Start
                Shopping</a>
        </div>
    @else
        <div class="card" style="overflow:hidden;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:var(--surface-2);">
                        @foreach(['Order', 'Date', 'Items', 'Status', 'Total', ''] as $h)
                            <th
                                style="padding:12px {{ $loop->last ? '24px' : '16px' }}; text-align:{{ $loop->last ? 'right' : 'left' }}; font-size:.8rem; font-weight:700; text-transform:uppercase; letter-spacing:.4px; color:var(--text-muted);">
                                {{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr style="border-top:1px solid var(--border);" onmouseover="this.style.background='var(--surface-2)'"
                            onmouseout="this.style.background=''">
                            <td style="padding:14px 16px;"><a href="{{ route('account.order.show', $order->order_number) }}"
                                    style="font-weight:600; color:var(--primary); font-size:.875rem;">{{ $order->order_number }}</a>
                            </td>
                            <td style="padding:14px 16px; font-size:.875rem; color:var(--text-muted);">
                                {{ $order->created_at->format('M d, Y') }}</td>
                            <td style="padding:14px 16px; font-size:.875rem; color:var(--text-muted);">{{ $order->items_count }}
                                items</td>
                            <td style="padding:14px 16px;"><span
                                    class="badge badge-{{ $order->status }}">{{ $order->statusLabel }}</span></td>
                            <td style="padding:14px 16px; font-weight:700;">৳{{ number_format($order->total, 2) }}</td>
                            <td style="padding:14px 24px; text-align:right;">
                                <a href="{{ route('account.order.show', $order->order_number) }}" class="btn btn-secondary"
                                    style="padding:6px 14px; font-size:.8rem;">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding:16px 24px; border-top:1px solid var(--border);">
                {{ $orders->links('partials.pagination') }}
            </div>
        </div>
    @endif
@endsection