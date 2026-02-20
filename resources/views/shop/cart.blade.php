@extends('layouts.shop')

@section('title', 'Your Cart')

@section('content')
    <div class="container" style="padding: 40px 20px;">
        <h1 style="font-size:1.8rem; font-weight:800; margin-bottom:8px;">Shopping Cart</h1>
        <p style="color:var(--text-muted); margin-bottom:32px;">{{ $cart->items->count() }} item(s) in your cart</p>

        @if($cart->items->isEmpty())
            <div class="card" style="padding:64px; text-align:center;">
                <i class="fa fa-cart-shopping" style="font-size:3.5rem; color:var(--text-light); margin-bottom:20px;"></i>
                <h2 style="margin-bottom:12px; color:var(--text-muted);">Your cart is empty</h2>
                <p style="color:var(--text-light); margin-bottom:24px;">Add some products to your cart to get started.</p>
                <a href="{{ route('home') }}" class="btn btn-primary" style="display:inline-flex;">Start Shopping <i
                        class="fa fa-arrow-right"></i></a>
            </div>

        @else
            <div style="display:grid; grid-template-columns:1fr 360px; gap:28px; align-items:start;">

                {{-- Cart Items --}}
                <div style="display:flex; flex-direction:column; gap:12px;">
                    @foreach($cart->items as $item)
                        <div class="card" style="padding:16px; display:flex; gap:16px; align-items:center;">
                            <div
                                style="width:88px; height:88px; border-radius:var(--radius-sm); overflow:hidden; background:var(--surface-3); flex-shrink:0;">
                                @if($item->product && $item->product->primaryImage)
                                    <img src="{{ Storage::url($item->product->primaryImage->path) }}"
                                        alt="{{ $item->product_name_snapshot }}" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <div
                                        style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--text-light);font-size:1.5rem;">
                                        <i class="fa fa-image"></i></div>
                                @endif
                            </div>
                            <div style="flex:1; min-width:0;">
                                <div style="font-weight:600; margin-bottom:4px; font-size:.95rem;">
                                    {{ $item->product_name_snapshot }}</div>
                                <div style="font-size:.875rem; color:var(--text-muted);">
                                    ৳{{ number_format($item->price_snapshot, 2) }} each</div>
                            </div>
                            <form action="{{ route('cart.update') }}" method="POST"
                                style="display:flex; align-items:center; gap:8px;">
                                @csrf
                                <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                <div
                                    style="display:flex; align-items:center; border:1.5px solid var(--border); border-radius:var(--radius-sm); overflow:hidden;">
                                    <button type="button"
                                        onclick="const i=this.nextElementSibling;i.value=Math.max(1,parseInt(i.value)-1);"
                                        style="width:32px;height:32px;border:none;background:var(--surface-3);cursor:pointer;">−</button>
                                    <input type="number" name="qty" value="{{ $item->qty }}" min="0" max="99"
                                        style="width:40px;height:32px;border:none;text-align:center;font-weight:600;font-size:.9rem;">
                                    <button type="button" onclick="const i=this.previousElementSibling;i.value=parseInt(i.value)+1;"
                                        style="width:32px;height:32px;border:none;background:var(--surface-3);cursor:pointer;">+</button>
                                </div>
                                <button type="submit" class="btn btn-secondary"
                                    style="padding:8px 14px; font-size:.8rem;">Update</button>
                            </form>
                            <div style="font-size:1rem; font-weight:700; color:var(--primary); min-width:80px; text-align:right;">
                                ৳{{ number_format($item->line_total, 2) }}</div>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                <button type="submit"
                                    style="width:32px;height:32px;border:none;background:transparent;color:var(--text-light);cursor:pointer;transition:var(--transition);"
                                    title="Remove" onmouseover="this.style.color='var(--danger)'"
                                    onmouseout="this.style.color='var(--text-light)'">
                                    <i class="fa fa-xmark"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                {{-- Order Summary --}}
                <div class="card" style="padding:24px; position:sticky; top:80px;">
                    <h3 style="font-size:1.1rem; font-weight:700; margin-bottom:20px;">Order Summary</h3>
                    <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:16px;">
                        <div style="display:flex; justify-content:space-between; font-size:.9rem; color:var(--text-muted);">
                            <span>Subtotal ({{ $totals['item_count'] }} items)</span>
                            <span>৳{{ number_format($totals['subtotal'], 2) }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:.9rem; color:var(--text-muted);">
                            <span>Delivery Fee</span>
                            <span>{{ $totals['delivery_fee'] > 0 ? '৳' . number_format($totals['delivery_fee'], 2) : '<span style="color:var(--success)">Free</span>' }}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div
                        style="display:flex; justify-content:space-between; font-weight:800; font-size:1.15rem; margin-bottom:20px;">
                        <span>Total</span>
                        <span style="color:var(--primary);">৳{{ number_format($totals['total'], 2) }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-full">
                        Proceed to Checkout <i class="fa fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-secondary btn-full" style="margin-top:10px;">
                        <i class="fa fa-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection