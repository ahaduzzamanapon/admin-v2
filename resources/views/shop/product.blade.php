@extends('layouts.shop')

@section('title', $product->name)

@push('styles')
    <style>
        .thumb-list {
            display: flex;
            gap: 8px;
            flex-direction: column;
        }

        .thumb-btn {
            width: 70px;
            height: 70px;
            border-radius: var(--radius-sm);
            border: 2px solid var(--border);
            overflow: hidden;
            cursor: pointer;
            transition: var(--transition);
        }

        .thumb-btn.active,
        .thumb-btn:hover {
            border-color: var(--primary);
        }

        .thumb-btn img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .qty-input {
            display: flex;
            align-items: center;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
            width: fit-content;
        }

        .qty-btn {
            width: 38px;
            height: 38px;
            border: none;
            background: var(--surface-3);
            cursor: pointer;
            font-size: 1rem;
            transition: var(--transition);
        }

        .qty-btn:hover {
            background: var(--border);
        }

        .qty-num {
            width: 48px;
            height: 38px;
            border: none;
            text-align: center;
            font-weight: 600;
            font-size: .95rem;
        }
    </style>
@endpush

@section('content')
    <div class="container" style="padding: 32px 20px;">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            @if($product->category)
                <a href="{{ route('shop.category', $product->category->slug) }}">{{ $product->category->name }}</a>
                <span>/</span>
            @endif
            <span>{{ $product->name }}</span>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:48px; margin-top:16px;">

            {{-- Image Gallery --}}
            <div style="display:flex; gap:16px;">
                <div class="thumb-list">
                    @foreach($product->images as $i => $img)
                        <button class="thumb-btn {{ $i === 0 ? 'active' : '' }}"
                            onclick="switchImage('{{ Storage::url($img->path) }}', this)">
                            <img src="{{ Storage::url($img->path) }}" alt="">
                        </button>
                    @endforeach
                </div>
                <div
                    style="flex:1; border-radius:var(--radius); overflow:hidden; background:var(--surface-3); aspect-ratio:1/1;">
                    <img id="mainImg" src="{{ $product->primaryImage ? Storage::url($product->primaryImage->path) : '' }}"
                        alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover;">
                </div>
            </div>

            {{-- Info --}}
            <div>
                @if($product->category)
                    <div
                        style="font-size:.8rem; font-weight:700; color:var(--primary); text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px;">
                        {{ $product->category->name }}
                    </div>
                @endif
                <h1 style="font-size:1.9rem; font-weight:800; line-height:1.2; margin-bottom:16px;">{{ $product->name }}
                </h1>
                <div style="font-size:2rem; font-weight:800; color:var(--primary); margin-bottom:20px;">
                    ৳{{ number_format($product->price, 2) }}</div>

                @if(!$product->isInStock())
                    <div class="alert alert-error" style="margin-bottom:20px;">
                        <i class="fa fa-ban"></i> This product is currently out of stock.
                    </div>
                @elseif($product->isLowStock())
                    <div class="alert alert-info" style="margin-bottom:20px;">
                        <i class="fa fa-clock"></i> Only {{ $product->stock_quantity }} left — order soon!
                    </div>
                @endif

                @if($product->short_description)
                    <p style="color:var(--text-muted); margin-bottom:24px; line-height:1.7;">{{ $product->short_description }}
                    </p>
                @endif

                @if($product->isInStock())
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div style="margin-bottom:20px;">
                            <label class="form-label">Quantity</label>
                            <div class="qty-input">
                                <button type="button" class="qty-btn" onclick="adjustQty(-1)">−</button>
                                <input type="number" name="qty" id="qtyInput" value="1" min="1"
                                    max="{{ $product->stock_quantity }}" class="qty-num">
                                <button type="button" class="qty-btn" onclick="adjustQty(1)">+</button>
                            </div>
                        </div>
                        <div style="display:flex; gap:12px; flex-wrap:wrap;">
                            <button type="submit" class="btn btn-primary" style="flex:1; min-width:160px;">
                                <i class="fa fa-cart-shopping"></i> Add to Cart
                            </button>
                            <a href="{{ route('checkout.index') }}" class="btn btn-secondary"
                                style="flex:1; min-width:120px; text-align:center; justify-content:center;">
                                Buy Now
                            </a>
                        </div>
                    </form>
                @endif

                <div class="divider"></div>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <div style="display:flex; align-items:center; gap:10px; font-size:.875rem; color:var(--text-muted);">
                        <i class="fa fa-truck-fast" style="color:var(--primary); width:18px;"></i>
                        <span>Fast delivery available</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:10px; font-size:.875rem; color:var(--text-muted);">
                        <i class="fa fa-money-bill" style="color:var(--primary); width:18px;"></i>
                        <span>Cash on Delivery accepted</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:10px; font-size:.875rem; color:var(--text-muted);">
                        <i class="fa fa-rotate-left" style="color:var(--primary); width:18px;"></i>
                        <span>Easy 30-day returns</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Description --}}
        @if($product->description)
            <div class="card" style="margin-top:40px; padding:32px;">
                <h3 style="font-size:1.1rem; font-weight:700; margin-bottom:16px;">Product Description</h3>
                <div style="color:var(--text-muted); line-height:1.8;">{{ $product->description }}</div>
            </div>
        @endif

        {{-- Related --}}
        @if($related->isNotEmpty())
            <section style="margin-top:48px;">
                <h2 class="section-title" style="margin-bottom:24px;">Related Products</h2>
                <div class="grid-4">
                    @foreach($related as $p)
                        @include('partials.product-card', ['product' => $p])
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function switchImage(src, btn) {
            document.getElementById('mainImg').src = src;
            document.querySelectorAll('.thumb-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
        function adjustQty(delta) {
            const inp = document.getElementById('qtyInput');
            const max = parseInt(inp.max);
            inp.value = Math.min(max, Math.max(1, parseInt(inp.value) + delta));
        }
    </script>
@endpush