@extends('layouts.shop')

@section('title', 'My Wishlist')

@section('content')
    <div class="section" style="padding-top:40px; min-height:600px;">
        <div class="container">
            <div class="section-header">
                <div class="section-title">My Wishlist</div>
            </div>

            @if($favorites->count() > 0)
                <div class="grid-4">
                    @foreach($favorites as $product)
                        @include('partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div style="margin-top:40px;">
                    {{ $favorites->links() }}
                </div>
            @else
                <div style="text-align:center; padding:60px 20px;">
                    <div style="font-size:3rem; color:var(--text-light); margin-bottom:16px;">
                        <i class="fa fa-heart-crack"></i>
                    </div>
                    <h3>Your wishlist is empty</h3>
                    <p style="color:var(--text-muted); margin-bottom:24px;">Browse our products and find something you love!</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary">Browse Products</a>
                </div>
            @endif
        </div>
    </div>
@endsection