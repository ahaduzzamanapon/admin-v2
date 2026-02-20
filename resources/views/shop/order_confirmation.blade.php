@extends('layouts.shop')

@section('title', 'Order Confirmed!')

@section('content')
    <div class="container" style="padding: 60px 20px; max-width: 640px;">
        <div class="card" style="padding: 48px; text-align: center;">
            <div
                style="width:80px;height:80px;background:linear-gradient(135deg,#10b981,#059669);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;box-shadow:0 8px 24px rgba(16,185,129,.3);">
                <i class="fa fa-check" style="font-size:1.8rem;color:#fff;"></i>
            </div>
            <h1 style="font-size:1.8rem;font-weight:800;margin-bottom:8px;">Order Placed!</h1>
            <p style="color:var(--text-muted);margin-bottom:28px;">Thank you! Your order
                <strong>{{ $order->order_number }}</strong> has been received and is being processed.</p>

            <div
                style="background:var(--surface-2);border-radius:var(--radius);padding:20px;text-align:left;margin-bottom:28px;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;font-size:.9rem;">
                    <div><span style="color:var(--text-muted);">Order
                            Number</span><br><strong>{{ $order->order_number }}</strong></div>
                    <div><span style="color:var(--text-muted);">Status</span><br><span
                            class="badge badge-{{ $order->status }}">{{ $order->statusLabel }}</span></div>
                    <div><span style="color:var(--text-muted);">Deliver
                            To</span><br><strong>{{ $order->shipping_name }}</strong></div>
                    <div><span style="color:var(--text-muted);">Total</span><br><strong
                            style="color:var(--primary);">৳{{ number_format($order->total, 2) }}</strong></div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:24px;">
                @foreach($order->items as $item)
                    <div
                        style="display:flex;gap:10px;align-items:center;background:var(--surface-3);border-radius:var(--radius-sm);padding:10px;">
                        <div style="font-size:.85rem;font-weight:600;flex:1;">{{ $item->product_name_snapshot }}</div>
                        <div style="font-size:.8rem;color:var(--text-muted);">× {{ $item->qty }}</div>
                        <div style="font-size:.85rem;font-weight:700;color:var(--primary);">
                            ৳{{ number_format($item->line_total, 2) }}</div>
                    </div>
                @endforeach
            </div>

            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                <a href="{{ route('order.track') }}" class="btn btn-primary">
                    <i class="fa fa-magnifying-glass"></i> Track Order
                </a>
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
@endsection