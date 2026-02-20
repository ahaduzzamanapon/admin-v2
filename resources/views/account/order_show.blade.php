@extends('layouts.account')

@section('title', 'Order ' . $order->order_number)

@section('account-content')
    <div style="display:flex; align-items:center; gap:12px; margin-bottom:24px; flex-wrap:wrap;">
        <a href="{{ route('account.orders') }}" style="color:var(--text-muted); font-size:.875rem;"><i
                class="fa fa-arrow-left"></i> Back to Orders</a>
        <h1 style="font-size:1.4rem; font-weight:800; margin:0;">{{ $order->order_number }}</h1>
        <span class="badge badge-{{ $order->status }}" style="margin-left:auto;">{{ $order->statusLabel }}</span>
    </div>

    <div style="display:grid; gap:16px;">
        {{-- Order Info --}}
        <div class="card" style="padding:24px;">
            <h3 style="font-size:1rem; font-weight:700; margin-bottom:16px;">Order Details</h3>
            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; font-size:.9rem;">
                <div><span style="color:var(--text-muted); font-size:.8rem; display:block; margin-bottom:4px;">Placed
                        On</span><strong>{{ $order->created_at->format('F j, Y g:i A') }}</strong></div>
                <div><span
                        style="color:var(--text-muted); font-size:.8rem; display:block; margin-bottom:4px;">Payment</span><strong>Cash
                        on Delivery</strong></div>
                <div><span style="color:var(--text-muted); font-size:.8rem; display:block; margin-bottom:4px;">Order
                        Total</span><strong
                        style="font-size:1.1rem; color:var(--primary);">৳{{ number_format($order->total, 2) }}</strong>
                </div>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
            {{-- Shipping --}}
            <div class="card" style="padding:24px;">
                <h3 style="font-size:1rem; font-weight:700; margin-bottom:12px;">Shipping To</h3>
                <div style="font-size:.9rem; color:var(--text-muted); line-height:1.8;">
                    <strong style="color:var(--text);">{{ $order->shipping_name }}</strong><br>
                    {{ $order->shipping_phone }}<br>
                    {{ $order->shipping_address }}<br>
                    {{ $order->shipping_city }}
                </div>
            </div>
            {{-- Notes --}}
            <div class="card" style="padding:24px;">
                <h3 style="font-size:1rem; font-weight:700; margin-bottom:12px;">Notes</h3>
                <p style="font-size:.9rem; color:var(--text-muted);">{{ $order->notes ?: 'No special instructions.' }}</p>
            </div>
        </div>

        {{-- Items --}}
        <div class="card" style="overflow:hidden;">
            <div style="padding:16px 24px; border-bottom:1px solid var(--border);">
                <h3 style="font-weight:700;">Items Ordered</h3>
            </div>
            @foreach($order->items as $item)
                <div
                    style="display:flex; gap:16px; align-items:center; padding:16px 24px; border-top:{{ $loop->first ? 'none' : '1px solid var(--border)' }};">
                    <div
                        style="width:60px;height:60px;border-radius:var(--radius-sm);overflow:hidden;background:var(--surface-3);flex-shrink:0;">
                        @if($item->product?->primaryImage)
                            <img src="{{ Storage::url($item->product->primaryImage->path) }}"
                                style="width:100%;height:100%;object-fit:cover;" alt="">
                        @else
                            <div
                                style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--text-light);">
                                <i class="fa fa-image"></i></div>
                        @endif
                    </div>
                    <div style="flex:1;">
                        <div style="font-weight:600; margin-bottom:2px;">{{ $item->product_name_snapshot }}</div>
                        <div style="font-size:.8rem; color:var(--text-muted);">৳{{ number_format($item->price_snapshot, 2) }} ×
                            {{ $item->qty }}</div>
                    </div>
                    <div style="font-weight:700; color:var(--primary);">৳{{ number_format($item->line_total, 2) }}</div>
                </div>
            @endforeach
            <div
                style="padding:16px 24px; border-top:1px solid var(--border); display:flex; flex-direction:column; gap:8px;">
                <div style="display:flex; justify-content:space-between; font-size:.9rem; color:var(--text-muted);">
                    <span>Subtotal</span><span>৳{{ number_format($order->subtotal, 2) }}</span></div>
                <div style="display:flex; justify-content:space-between; font-size:.9rem; color:var(--text-muted);">
                    <span>Delivery</span><span>{{ $order->delivery_fee > 0 ? '৳' . number_format($order->delivery_fee, 2) : 'Free' }}</span>
                </div>
                <div class="divider" style="margin:8px 0;"></div>
                <div style="display:flex; justify-content:space-between; font-weight:800; font-size:1.05rem;">
                    <span>Total</span><span style="color:var(--primary);">৳{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection