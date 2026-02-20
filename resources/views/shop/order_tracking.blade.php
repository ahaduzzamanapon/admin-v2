@extends('layouts.shop')

@section('title', 'Track Your Order')

@section('content')
    <div class="container" style="padding: 60px 20px; max-width: 680px;">
        <div style="text-align:center; margin-bottom:36px;">
            <h1 style="font-size:2rem; font-weight:800; margin-bottom:8px;">Track Your Order</h1>
            <p style="color:var(--text-muted);">Enter your order number to see the current status</p>
        </div>

        <div class="card" style="padding:28px; margin-bottom:28px;">
            <form action="{{ route('order.track.post') }}" method="POST">
                @csrf
                <div style="display:flex; gap:12px;">
                    <div style="flex:1;">
                        <input type="text" name="order_number" class="form-control" placeholder="e.g. ORD-20260219-XXXXX"
                            value="{{ old('order_number', isset($order) ? $order->order_number : '') }}" required
                            style="font-size:1rem;">
                        @error('order_number')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary" style="white-space:nowrap;">
                        <i class="fa fa-magnifying-glass"></i> Track
                    </button>
                </div>
            </form>
            @if(session('error'))
                <div class="alert alert-error" style="margin-top:16px; margin-bottom:0;">
                    <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
        </div>

        @isset($order)
            <div class="card" style="padding:28px;">
                <div
                    style="display:flex; justify-content:space-between; align-items:start; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
                    <div>
                        <div style="font-size:.8rem; color:var(--text-muted); margin-bottom:4px;">ORDER NUMBER</div>
                        <div style="font-size:1.1rem; font-weight:800;">{{ $order->order_number }}</div>
                    </div>
                    <span class="badge badge-{{ $order->status }}"
                        style="font-size:.8rem; padding:6px 14px;">{{ $order->statusLabel }}</span>
                </div>

                {{-- Status Timeline --}}
                @php
                    $steps = [
                        'pending' => ['Pending', 'fa-clock'],
                        'confirmed' => ['Confirmed', 'fa-circle-check'],
                        'packed' => ['Packed', 'fa-box'],
                        'out_for_delivery' => ['Out for Delivery', 'fa-truck-fast'],
                        'delivered' => ['Delivered', 'fa-house-chimney'],
                    ];
                    $statusOrder = array_keys($steps);
                    $currentIdx = array_search($order->status, $statusOrder);
                @endphp
                @if($currentIdx !== false)
                    <div style="position:relative; margin-bottom:28px; padding: 0 8px;">
                        <div
                            style="position:absolute; top:18px; left:28px; right:28px; height:2px; background:var(--border); z-index:0;">
                        </div>
                        <div
                            style="position:absolute; top:18px; left:28px; height:2px; width:{{ ($currentIdx / (count($steps) - 1)) * 100 }}%; background:var(--primary); z-index:1; transition:width 1s ease;">
                        </div>
                        <div style="display:flex; justify-content:space-between; position:relative; z-index:2;">
                            @foreach($steps as $key => [$label, $icon])
                                @php $idx = array_search($key, $statusOrder);
                                $done = $idx <= $currentIdx; @endphp
                                <div
                                    style="display:flex; flex-direction:column; align-items:center; gap:8px; text-align:center; max-width:80px;">
                                    <div
                                        style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.85rem;background:{{ $done ? 'var(--primary)' : 'var(--surface-3)' }};color:{{ $done ? '#fff' : 'var(--text-light)' }};border:2px solid {{ $done ? 'var(--primary)' : 'var(--border)' }};transition:all .3s;">
                                        <i class="fa {{ $icon }}"></i>
                                    </div>
                                    <span
                                        style="font-size:.72rem;font-weight:600;color:{{ $done ? 'var(--primary)' : 'var(--text-light)' }};">{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="divider"></div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; font-size:.9rem; margin-bottom:20px;">
                    <div><span style="color:var(--text-muted);">Deliver
                            To</span><br><strong>{{ $order->shipping_name }}</strong><br><span
                            style="color:var(--text-muted);">{{ $order->shipping_address }}, {{ $order->shipping_city }}</span>
                    </div>
                    <div style="text-align:right;"><span style="color:var(--text-muted);">Order Total</span><br><strong
                            style="color:var(--primary);font-size:1.1rem;">৳{{ number_format($order->total, 2) }}</strong></div>
                </div>

                <div style="display:flex; flex-direction:column; gap:8px;">
                    @foreach($order->items as $item)
                        <div
                            style="display:flex; justify-content:space-between; align-items:center; background:var(--surface-2); padding:10px 14px; border-radius:var(--radius-sm);">
                            <span style="font-size:.875rem; font-weight:500;">{{ $item->product_name_snapshot }} <span
                                    style="color:var(--text-muted);">× {{ $item->qty }}</span></span>
                            <span style="font-size:.875rem; font-weight:700;">৳{{ number_format($item->line_total, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endisset
    </div>
@endsection