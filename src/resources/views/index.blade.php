@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection


@section('content')
<div class="form__header">
    <div class="link">
        <a href="/" class="product__heading-btn btn">おすすめ</a>
        <a href="/">マイリスト</a>
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
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection