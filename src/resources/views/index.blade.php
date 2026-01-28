@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection


@section('content')
<div class="form__header">
    <div class="product-form__header">
        <h2>商品一覧</h2>
    </div>
    <div class="link">
        <a href="/products/register" class="product__heading-btn btn">+ 商品を追加</a>
    </div>
</div>
<div class="form__content">
    <div class="sidebar">
        <form class="search-form" action="/search" method="get">
            <input class="search-form__name-input" type="text" name="name" placeholder="商品名で検索">
            <div class="search-form__actions">
                <input class="search-form__search-btn btn" type="submit" value="検索">
            </div>
            <div class="select-form">
                <h3 class="select-form__header">価格順で表示</h3>
                <select class="sort-select" name="sort" id="sort">
                    <option value=""></option>
                    <option value="desc">高い順に表示</option>
                    <option value="asc">安い順に表示</option>
                </select>
            </div>
        </form>
    </div>
    <div class="product-form__group">
        @foreach($products as $product)
        <div class="product-form__item">
            <a href="/products/{{ $product->id }}">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                <div class="product-form__item-list">
                    <h4>{{ $product->name }}</h4>
                    <p>¥{{ $product->price }}</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('footer')
<div class="pagination">
    {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
</div>
@endsection