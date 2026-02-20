@extends('layouts.shop')

@section('title', 'Home')

@section('content')

    {{-- ═══════════════════════════════ HERO + SIDEBAR LAYOUT ═══════════════════════════════ --}}
    <div style="background:#fff; border-bottom:1px solid var(--border);">
        <div class="container" style="padding:0;">
            <div class="home-layout">

                {{-- LEFT SIDEBAR --}}
                <div class="home-sidebar">
                    @forelse($categories as $cat)
                        <a href="{{ route('shop.category', $cat->slug) }}" class="home-sidebar-item">
                            @if($cat->icon)<i class="fa {{ $cat->icon }}"></i>@else<i class="fa fa-tag"></i>@endif
                            {{ $cat->name }}
                            @if($cat->active_products_count > 0)
                                <span
                                    style="margin-left:auto; font-size:.7rem; color:var(--text-light);">{{ $cat->active_products_count }}</span>
                            @endif
                        </a>
                    @empty
                        <div class="home-sidebar-item" style="color:var(--text-muted);">No categories yet</div>
                    @endforelse
                </div>

                {{-- HERO SLIDER: fixed-height container --}}
                <div class="hero-slider" id="heroSlider" style="height:420px; overflow:hidden; position:relative;">

                    {{-- ===== Slide 1 : TV ===== --}}
                    <div class="hero-slide active">
                        <div class="hero-bg"
                            style="background-image:url('https://images.unsplash.com/photo-1593784991095-a205069470b6?w=1200&q=80');">
                        </div>
                        <div class="hero-slide-overlay"
                            style="background:linear-gradient(to right,rgba(5,10,30,.90) 0%,rgba(5,10,30,.55) 55%,rgba(5,10,30,.1) 100%);">
                        </div>
                        <div class="hero-slide-content"
                            style="padding:64px 52px; position:relative; z-index:2; max-width:520px;">
                            <div class="hero-slide-tag" style="margin-bottom:14px;"><i class="fa fa-bolt"
                                    style="color:#fbbf24;"></i>&nbsp; TRENDING NOW</div>
                            <div class="hero-slide-title" style="font-size:3.6rem; text-shadow:0 2px 24px rgba(0,0,0,.5);">
                                THINK BIGGER<br><span style="font-size:2.2rem;font-weight:700;opacity:.9;">WITH YOUR
                                    TV</span>
                            </div>
                            <div class="hero-slide-sub" style="margin:16px 0 28px; font-size:1rem;">Up to <strong>30%
                                    off</strong> on 4K OLED &amp; QLED Smart TVs.<br>Limited time offer &mdash; shop now!
                            </div>
                            <a href="{{ route('shop.category', 'tvs-monitors') }}" class="hero-cta"
                                style="font-size:.95rem;padding:13px 32px;">Shop TVs &nbsp;<i
                                    class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>

                    {{-- ===== Slide 2 : Smartphones ===== --}}
                    <div class="hero-slide">
                        <div class="hero-bg"
                            style="background-image:url('https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=1200&q=80');">
                        </div>
                        <div class="hero-slide-overlay"
                            style="background:linear-gradient(to right,rgba(0,10,20,.90) 0%,rgba(0,10,20,.55) 55%,rgba(0,10,20,.1) 100%);">
                        </div>
                        <div class="hero-slide-content"
                            style="padding:64px 52px; position:relative; z-index:2; max-width:520px;">
                            <div class="hero-slide-tag" style="margin-bottom:14px;"><i class="fa fa-mobile-screen"
                                    style="color:#34d399;"></i>&nbsp; NEW ARRIVAL</div>
                            <div class="hero-slide-title" style="font-size:3.4rem; text-shadow:0 2px 24px rgba(0,0,0,.5);">
                                NEXT-GEN<br><span style="font-size:2.2rem;font-weight:700;opacity:.9;">SMARTPHONES</span>
                            </div>
                            <div class="hero-slide-sub" style="margin:16px 0 28px; font-size:1rem;">5G phones with
                                <strong>flagship cameras</strong>.<br>Starting from &#2547;18,000 only.
                            </div>
                            <a href="{{ route('shop.category', 'smartphones') }}" class="hero-cta"
                                style="background:#10b981;font-size:.95rem;padding:13px 32px;">Shop Phones &nbsp;<i
                                    class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>

                    {{-- ===== Slide 3 : Gaming ===== --}}
                    <div class="hero-slide">
                        <div class="hero-bg"
                            style="background-image:url('https://images.unsplash.com/photo-1616588589676-62b3bd4ff6d2?w=1200&q=80');">
                        </div>
                        <div class="hero-slide-overlay"
                            style="background:linear-gradient(to right,rgba(10,0,40,.90) 0%,rgba(10,0,40,.55) 55%,rgba(10,0,40,.1) 100%);">
                        </div>
                        <div class="hero-slide-content"
                            style="padding:64px 52px; position:relative; z-index:2; max-width:520px;">
                            <div class="hero-slide-tag" style="margin-bottom:14px;"><i class="fa fa-gamepad"
                                    style="color:#a78bfa;"></i>&nbsp; LEVEL UP</div>
                            <div class="hero-slide-title" style="font-size:3.4rem; text-shadow:0 2px 24px rgba(0,0,0,.6);">
                                GAMING<br><span style="font-size:2.2rem;font-weight:700;opacity:.9;">ACCESSORIES</span>
                            </div>
                            <div class="hero-slide-sub" style="margin:16px 0 28px; font-size:1rem;">RGB keyboards, headsets
                                &amp; controllers.<br><strong>Best prices guaranteed.</strong></div>
                            <a href="{{ route('shop.category', 'gaming-accessories') }}" class="hero-cta"
                                style="background:#7c3aed;font-size:.95rem;padding:13px 32px;">Shop Gaming &nbsp;<i
                                    class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>

                    {{-- Nav dots --}}
                    <div class="hero-dots" id="heroDots" style="z-index:20;">
                        <button class="hero-dot active" onclick="goSlide(0)"></button>
                        <button class="hero-dot" onclick="goSlide(1)"></button>
                        <button class="hero-dot" onclick="goSlide(2)"></button>
                    </div>

                </div>{{-- /hero-slider --}}
            </div>{{-- /home-layout --}}
        </div>
    </div>

    {{-- ═══════════════════════════════ FEATURE STRIP ═══════════════════════════════ --}}
    <div class="feature-strip reveal">
        <div class="container">
            <div class="feature-strip-inner">
                <div class="feature-item">
                    <span class="feature-icon"><i class="fa fa-truck-fast"></i></span>
                    <div>
                        <div class="feature-label">Fast Delivery</div>
                        <div class="feature-sub">On all orders nationwide</div>
                    </div>
                </div>
                <div class="feature-item">
                    <span class="feature-icon"><i class="fa fa-shield-halved"></i></span>
                    <div>
                        <div class="feature-label">Secure Payment</div>
                        <div class="feature-sub">Cash on delivery available</div>
                    </div>
                </div>
                <div class="feature-item">
                    <span class="feature-icon"><i class="fa fa-arrow-rotate-left"></i></span>
                    <div>
                        <div class="feature-label">Easy Returns</div>
                        <div class="feature-sub">7-day return policy</div>
                    </div>
                </div>
                <div class="feature-item">
                    <span class="feature-icon"><i class="fa fa-headset"></i></span>
                    <div>
                        <div class="feature-label">24/7 Support</div>
                        <div class="feature-sub">Always here to help</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════ CATEGORY CARDS ═══════════════════════════════ --}}
    <div class="section reveal" style="padding:28px 0 0;">
        <div class="container">
            <div class="section-header">
                <div class="section-title">Shop by Category</div>
                <a href="{{ route('shop.index') }}" class="view-all">See All <i class="fa fa-chevron-right"></i></a>
            </div>
            <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:12px; padding-bottom:28px;">
                @forelse($categories->take(10) as $cat)
                    <a href="{{ route('shop.category', $cat->slug) }}" class="cat-card">
                        <div class="cat-card-icon"><i class="fa {{ $cat->icon ?? 'fa-tag' }}"></i></div>
                        <div class="cat-card-name">{{ \Illuminate\Support\Str::limit($cat->name, 18) }}</div>
                        @if($cat->active_products_count > 0)
                            <div class="cat-card-count">{{ $cat->active_products_count }} products</div>
                        @endif
                    </a>
                @empty
                    <p style="color:var(--text-muted);">No categories found.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════ FEATURED PRODUCTS ═══════════════════════════════ --}}
    @if($featured->isNotEmpty())
        <div class="section reveal" style="padding-top:28px;">
            <div class="container">
                <div class="section-header">
                    <div class="section-title"><i class="fa fa-star" style="color:#f59e0b; font-size:.9rem;"></i> Featured
                        Products</div>
                    <a href="{{ route('home') }}" class="view-all">View All <i class="fa fa-chevron-right"></i></a>
                </div>
                <div class="grid-4">
                    @foreach($featured->take(8) as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ═══════════════ PROMO BANNER (2-col · dynamic) ═══════════════ --}}
    @if($promos2col->isNotEmpty())
        <div class="reveal" style="padding:24px 0;">
            <div class="container">
                <div style="display:grid; grid-template-columns:repeat({{ min($promos2col->count(), 2) }},1fr); gap:16px;">
                    @foreach($promos2col as $banner)
                        <div
                            style="background:linear-gradient(135deg,{{ $banner->color_from }},{{ $banner->color_to }}); border-radius:var(--radius); padding:28px 32px; color:#fff; position:relative; overflow:hidden;">
                            <div
                                style="position:absolute;right:-20px;top:50%;transform:translateY(-50%);font-size:8rem;opacity:.1;">
                                <i class="fa {{ $banner->icon }}"></i>
                            </div>
                            <div
                                style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:2px;opacity:.8;margin-bottom:8px;">
                                {{ $banner->tag }}
                            </div>
                            <div style="font-size:1.8rem;font-weight:900;line-height:1.2;margin-bottom:8px;">
                                {!! nl2br(e($banner->title)) !!}
                            </div>
                            @if($banner->subtitle)
                                <div style="font-size:.85rem;opacity:.8;margin-bottom:20px;">{{ $banner->subtitle }}</div>
                            @endif
                            <a href="{{ $banner->resolveUrl() }}"
                                style="display:inline-flex;align-items:center;gap:6px;background:#fff;color:{{ $banner->color_from }};padding:9px 20px;border-radius:var(--radius-sm);font-weight:700;font-size:.85rem;">
                                {{ $banner->link_label }} <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ═══════════════════════════════ TRENDING PRODUCTS ═══════════════════════════════ --}}
    @if($trending->isNotEmpty())
        <div class="section reveal" style="padding-top:8px;">
            <div class="container">
                <div class="section-header">
                    <div class="section-title"><i class="fa fa-fire" style="color:#ef4444; font-size:.9rem;"></i> Trending
                        Products</div>
                    <a href="{{ route('home') }}" class="view-all">View All <i class="fa fa-chevron-right"></i></a>
                </div>
                <div class="grid-5">
                    @foreach($trending->take(10) as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ═══════════════════════════════ NEW ARRIVALS ═══════════════════════════════ --}}
    @if($latest->isNotEmpty())
        <div class="section reveal" style="padding-top:8px;">
            <div class="container">
                <div class="section-header">
                    <div class="section-title"><i class="fa fa-sparkles" style="color:#10b981; font-size:.9rem;"></i> New
                        Arrivals</div>
                    <a href="{{ route('home') }}" class="view-all">View All <i class="fa fa-chevron-right"></i></a>
                </div>
                <div class="grid-5">
                    @foreach($latest->take(10) as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ═══════════════ BOTTOM PROMO 3-col (dynamic) ═══════════════ --}}
    @if($promos3col->isNotEmpty())
        <div style="padding:24px 0 32px;">
            <div class="container">
                <div style="display:grid; grid-template-columns:repeat({{ min($promos3col->count(), 3) }},1fr); gap:16px;">
                    @foreach($promos3col as $banner)
                        <div
                            style="background:linear-gradient(135deg,{{ $banner->color_from }},{{ $banner->color_to }}); border-radius:var(--radius); padding:22px 24px; color:#fff; position:relative; overflow:hidden; display:flex; flex-direction:column; gap:6px;">
                            <div
                                style="position:absolute;right:-10px;top:50%;transform:translateY(-50%);font-size:6rem;opacity:.1;">
                                <i class="fa {{ $banner->icon }}"></i>
                            </div>
                            <div style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;opacity:.75;">
                                {{ $banner->tag }}
                            </div>
                            <div style="font-size:1.3rem;font-weight:800;line-height:1.2;">{{ $banner->title }}</div>
                            @if($banner->subtitle)
                                <div style="font-size:.8rem;opacity:.8;">{{ $banner->subtitle }}</div>
                            @endif
                            <a href="{{ $banner->resolveUrl() }}"
                                style="margin-top:8px;display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,.15);color:#fff;padding:7px 14px;border-radius:var(--radius-sm);font-weight:600;font-size:.8rem;border:1px solid rgba(255,255,255,.25);"
                                onmouseover="this.style.background='rgba(255,255,255,.25)'"
                                onmouseout="this.style.background='rgba(255,255,255,.15)'">
                                {{ $banner->link_label }} <i class="fa fa-arrow-right"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @push('scripts')
        <script>
            // ─── Hero Slider ────────────────────────────────────────────
            (function () {
                const slides = document.querySelectorAll('#heroSlider .hero-slide');
                const N = slides.length;
                let cur = 0;

                // Initial setup
                slides.forEach((s, i) => {
                    s.style.transition = 'opacity .6s ease';
                    s.style.opacity = i === 0 ? '1' : '0';
                    s.style.pointerEvents = i === 0 ? 'auto' : 'none';
                    s.classList.toggle('active', i === 0);
                });

                function updateDots(n) {
                    document.querySelectorAll('#heroDots .hero-dot').forEach((dot, i) => {
                        dot.classList.toggle('active', i === n);
                    });
                }

                window.goSlide = function (n) {
                    if (n === cur) return;

                    // Outgoing
                    slides[cur].style.opacity = '0';
                    slides[cur].style.pointerEvents = 'none';
                    slides[cur].classList.remove('active');

                    cur = n;

                    // Incoming
                    slides[cur].style.opacity = '1';
                    slides[cur].style.pointerEvents = 'auto';
                    slides[cur].classList.add('active');

                    updateDots(cur);
                };

                setInterval(() => { goSlide((cur + 1) % N); }, 6000); // Increased to 6s to let animations breathe
            })();
        </script>
    @endpush
@endsection