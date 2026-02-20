@extends('layouts.shop')

@section('title', 'Browse All Products')

@section('content')
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <span>Shop</span>
        </div>
    </div>

    <div class="container" style="padding-bottom: 60px;">
        <div style="display: grid; grid-template-columns: 240px 1fr; gap: 28px; align-items: start;">

            {{-- Sidebar --}}
            <aside>
                <div class="card" style="padding: 20px;">
                    <div
                        style="font-weight: 700; font-size: .85rem; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); margin-bottom: 14px;">
                        Categories</div>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 4px;">
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('shop.category', $cat->slug) }}" style="
                                            display: flex; justify-content: space-between; align-items: center;
                                            padding: 9px 12px; border-radius: var(--radius-sm);
                                            font-size: .9rem; font-weight: 500;
                                            color: var(--text);
                                            transition: var(--transition);
                                        ">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            {{-- Main --}}
            <div>
                <div
                    style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
                    <h1 style="font-size: 1.6rem; font-weight: 800;">All Products</h1>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: .85rem; color: var(--text-muted);">{{ $products->total() }} products</span>
                        <form method="GET" style="margin: 0;">
                            <select name="sort" onchange="this.form.submit()" class="form-control"
                                style="width: auto; padding: 8px 12px; font-size: .85rem;">
                                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price:
                                    Low–High</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price:
                                    High–Low</option>
                                <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Name A–Z
                                </option>
                            </select>
                        </form>
                    </div>
                </div>

                @if($products->isEmpty())
                    <div class="card" style="padding: 48px; text-align: center;">
                        <i class="fa fa-box-open" style="font-size: 3rem; color: var(--text-light); margin-bottom: 16px;"></i>
                        <h3 style="color: var(--text-muted);">No products found</h3>
                        <a href="{{ route('home') }}" class="btn btn-primary"
                            style="display: inline-flex; margin-top: 20px;">Return Home</a>
                    </div>
                @else
                    <div class="grid-4" style="grid-template-columns: repeat(3, 1fr);">
                        @foreach($products as $product)
                            @include('partials.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="pagination">
                        {{ $products->onEachSide(1)->links('partials.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection