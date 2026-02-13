@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection


@section('content')
<div class="form__header">
    <div class="link">
        <a href="/" class="product__heading-btn btn {{ request('tag') !== 'mylist' ? 'active' : '' }}">おすすめ</a>
        <a href="/?tag=mylist" class="product__heading-btn btn {{ request('tag') === 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>
</div>
<div class="form__content">
    <div class="product-form__group">
        @foreach($items as $item)
        <div class="product-form__item">
            <a href="/item/{{ $item->id }}">
                <img src="{{ asset($item->image_url) }}" alt="{{ $item->item_name }}">
                <div class="product-form__item-list">
                    <h4>{{ $item->item_name }}</h4>
                    <p>¥{{ $item->item_amount }}</p>
                    @if($item->order)
                    <div class="sold-tag">SOLD</div>
                    @endif
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection