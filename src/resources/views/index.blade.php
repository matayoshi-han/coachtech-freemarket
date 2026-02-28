@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection


@section('content')
<div class="form__header">
    <div class="form__header-link">
        <a href="/?keyword={{ request('keyword') }}"
            class="product__heading-btn btn {{ request('tag') !== 'mylist' ? 'active' : '' }}">
            おすすめ
        </a>
        <a href="/?tag=mylist&keyword={{ request('keyword') }}"
            class="product__heading-btn btn {{ request('tag') === 'mylist' ? 'active' : '' }}">
            マイリスト
        </a>
    </div>
</div>
<div class="form__content">
    <div class="product-form__group">
        @foreach($items as $item)
        <div class="product-form__item">
            <a href="/item/{{ $item->id }}">
                <div class="product-image-container">
                    <img src="{{ asset($item->image_url) }}" alt="{{ $item->item_name }}">
                    @if($item->order)
                    <div class="sold-label">Sold</div>
                    @endif
                </div>
                <div class="product-form__item-list">
                    <h4>{{ $item->item_name }}</h4>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection