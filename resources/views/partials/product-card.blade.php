<div class="product-card">
    {{-- Image --}}
    <div class="product-card-img">
        @if($product->primaryImage)
            @php $imgPath = $product->primaryImage->path; @endphp
            @if(Str::startsWith($imgPath, 'http'))
                <img src="{{ $imgPath }}" alt="{{ $product->name }}" loading="lazy">
            @else
                <img src="{{ Storage::url($imgPath) }}" alt="{{ $product->name }}" loading="lazy">
            @endif
        @else
            <div
                style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--text-light);font-size:2rem;">
                <i class="fa fa-image"></i>
            </div>
        @endif

        {{-- Badge --}}
        @if(!$product->isInStock())
            <span class="product-card-badge out">Out of Stock</span>
        @elseif($product->old_price && $product->old_price > $product->price)
            @php $discount = round((($product->old_price - $product->price) / $product->old_price) * 100); @endphp
            <span class="product-card-badge">-{{ $discount }}%</span>
        @else
            <span class="product-card-badge new">New</span>
        @endif

        {{-- Hover actions --}}
        <div class="product-card-actions">
            <a href="{{ route('shop.product', $product->slug) }}" class="product-card-action" title="View Product">
                <i class="fa fa-eye"></i>
            </a>
            @auth
                <button
                    class="product-card-action wishlist-btn {{ Auth::user()->favorites->contains($product->id) ? 'active' : '' }}"
                    data-id="{{ $product->id }}" onclick="toggleWishlist(this, {{ $product->id }})" title="Add to Wishlist">
                    <i class="fa fa-heart"></i>
                </button>
            @else
                <a href="{{ route('login') }}" class="product-card-action" title="Login to Wishlist">
                    <i class="fa fa-heart"></i>
                </a>
            @endauth
        </div>
    </div>

    {{-- Body --}}
    <div class="product-card-body">
        @if($product->category)
            <div class="product-card-category">{{ $product->category->name }}</div>
        @endif
        <a href="{{ route('shop.product', $product->slug) }}" class="product-card-name">
            {{ $product->name }}
        </a>
        <div class="product-card-price">
            ৳{{ number_format($product->price, 0) }}
            @if($product->old_price && $product->old_price > $product->price)
                <span
                    style="font-size:.75rem; font-weight:500; color:var(--text-muted); text-decoration:line-through; margin-left:4px;">৳{{ number_format($product->old_price, 0) }}</span>
            @endif
        </div>
    </div>

    {{-- Footer / Add to Cart --}}
    <div class="product-card-footer">
        @if($product->isInStock())
            <button class="btn-add-cart" onclick="addToCart({{ $product->id }})">
                <i class="fa fa-cart-plus"></i> Add to Cart
            </button>
        @else
            <button class="btn-add-cart" disabled>
                <i class="fa fa-ban"></i> Out of Stock
            </button>
        @endif
    </div>
</div>