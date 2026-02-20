@extends('layouts.shop')

@section('title', 'Checkout')

@section('content')
    <div class="container" style="padding: 40px 20px;">
        <h1 style="font-size:1.8rem; font-weight:800; margin-bottom:32px;">Checkout</h1>

        <form action="{{ route('checkout.place') }}" method="POST">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 380px; gap:28px; align-items:start;">

                {{-- Shipping Form --}}
                <div>
                    <div class="card" style="padding:28px; margin-bottom:16px;">
                        <h3
                            style="font-size:1.05rem; font-weight:700; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
                            <span
                                style="background:var(--primary);color:#fff;width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;">1</span>
                            Shipping Information
                        </h3>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                            <div class="form-group">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="shipping_name" class="form-control"
                                    value="{{ old('shipping_name', $user?->name) }}" required placeholder="Your full name">
                                @error('shipping_name')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone Number *</label>
                                <input type="tel" name="shipping_phone" class="form-control"
                                    value="{{ old('shipping_phone', $user?->phone) }}" required placeholder="01XXXXXXXXX">
                                @error('shipping_phone')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Full Address *</label>
                            <input type="text" name="shipping_address" class="form-control"
                                value="{{ old('shipping_address') }}" required placeholder="House no, Road, Area">
                            @error('shipping_address')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">City *</label>
                            <input type="text" name="shipping_city" class="form-control" value="{{ old('shipping_city') }}"
                                required placeholder="Dhaka">
                            @error('shipping_city')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Order Notes (Optional)</label>
                            <textarea name="notes" class="form-control"
                                placeholder="Special instructions for your order...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="card" style="padding:28px;">
                        <h3
                            style="font-size:1.05rem; font-weight:700; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
                            <span
                                style="background:var(--primary);color:#fff;width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.75rem;">2</span>
                            Payment Method
                        </h3>
                        <label
                            style="display:flex; align-items:center; gap:12px; padding:16px; border:2px solid var(--primary); border-radius:var(--radius); cursor:pointer; background:rgb(99 102 241 / .05);">
                            <input type="radio" name="payment_method" value="cod" checked
                                style="width:18px;height:18px;accent-color:var(--primary);">
                            <div>
                                <div style="font-weight:700; margin-bottom:2px;">Cash on Delivery</div>
                                <div style="font-size:.8rem; color:var(--text-muted);">Pay when your order arrives at your
                                    door</div>
                            </div>
                            <i class="fa fa-money-bill-wave"
                                style="margin-left:auto; font-size:1.3rem; color:var(--success);"></i>
                        </label>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="card" style="padding:24px; position:sticky; top:80px;">
                    <h3 style="font-size:1.05rem; font-weight:700; margin-bottom:20px;">Order Summary</h3>
                    <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:16px;">
                        @foreach($cart->items as $item)
                            <div style="display:flex; gap:12px; align-items:center;">
                                <div
                                    style="width:44px;height:44px;border-radius:8px;overflow:hidden;background:var(--surface-3);flex-shrink:0;">
                                    @if($item->product?->primaryImage)
                                        <img src="{{ Storage::url($item->product->primaryImage->path) }}"
                                            style="width:100%;height:100%;object-fit:cover;" alt="">
                                    @endif
                                </div>
                                <div style="flex:1; min-width:0;">
                                    <div
                                        style="font-size:.85rem; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                        {{ $item->product_name_snapshot }}</div>
                                    <div style="font-size:.75rem; color:var(--text-muted);">× {{ $item->qty }}</div>
                                </div>
                                <div style="font-size:.95rem; font-weight:700; white-space:nowrap;">
                                    ৳{{ number_format($item->line_total, 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="divider"></div>
                    <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:16px;">
                        <div style="display:flex; justify-content:space-between; font-size:.9rem; color:var(--text-muted);">
                            <span>Subtotal</span><span>৳{{ number_format($totals['subtotal'], 2) }}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:.9rem; color:var(--text-muted);">
                            <span>Delivery</span>
                            <span>{{ $totals['delivery_fee'] > 0 ? '৳' . number_format($totals['delivery_fee'], 2) : 'Free' }}</span>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div
                        style="display:flex; justify-content:space-between; font-weight:800; font-size:1.15rem; margin-bottom:20px;">
                        <span>Total</span>
                        <span style="color:var(--primary);">৳{{ number_format($totals['total'], 2) }}</span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full" style="font-size:1rem;">
                        <i class="fa fa-circle-check"></i> Place Order
                    </button>
                    <p style="text-align:center; font-size:.75rem; color:var(--text-light); margin-top:12px;">
                        <i class="fa fa-lock"></i> Your order is secure and encrypted
                    </p>
                </div>
            </div>
        </form>
    </div>
@endsection