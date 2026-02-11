@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css')}}">
@endsection

@section('content')
<div class="item-detail__container">
    <div class="item-detail__image">
        <img src="{{ asset($item->image_url) }}" alt="{{ $item->item_name }}">
    </div>
    <div class="item-detail__info">
        <h2>{{ $item->item_name }}</h2>
        <p>{{ $item->item_brand ?? '' }}</p>
        <p>¥{{ $item->item_amount }}</p>
        <a href="/purchase/{{ $item->id }}">購入手続きへ</a>
        <div class="item-detail__description">
            <h3>商品説明</h3>
            <p>{{ $item->item_description }}</p>
            <h3>商品の情報</h3>
            <p>カテゴリー: {{ $category->category_name }}</p>
            <p>商品の状態: {{ $item->item_state }}</p>
        </div>
    <div class="item-detail__comment">
        <h3>コメント ({{count($comments)}})</h3>
        @foreach ($comments as $comment)
            <p>{{ $comment->text }}</p>
        @endforeach
        <form action="/comment/{{ $item->id }}" method="POST">
            @csrf
            <textarea name="text" rows="4" cols="50"></textarea>
            <button type="submit">コメントを送信する</button>
        </form>
    </div>
    </div>
</div>
@endsection