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
        <p>¥{{ number_format($item->item_amount) }}（税込）</p>
        <div class="item-detail__actions">
            <div class="action-item">
                <form action="/like/{{ $item->id }}" method="POST">
                    @csrf
                    <button type="submit" class="icon-button">
                        @if(auth()->check() && $item->isLiked(auth()->id()))
                        <img src="{{ asset('images/ハートロゴ_ピンク.png') }}" alt="いいね済み">
                        @else
                        <img src="{{ asset('images/ハートロゴ_デフォルト.png') }}" alt="いいね">
                        @endif
                    </button>
                </form>
                <span class="action-count">{{ $item->likes()->count() }}</span>
            </div>
            <div class="action-item">
                <div class="icon-button">
                    <img src="{{ asset('images/ふきだしロゴ.png') }}" alt="コメント">
                </div>
                <span class="action-count">{{ count($item->comments) }}</span>
            </div>
        </div>
    </div>
    <a href="/purchase/{{ $item->id }}">購入手続きへ</a>
    <div class="item-detail__description">
        <h3>商品説明</h3>
        <p>{{ $item->item_description }}</p>
        <h3>商品の情報</h3>
        <div>カテゴリー:
            @foreach($item->categories as $category)
            <span class="category-tag">{{ $category->category_name }}</span>
            @endforeach
        </div>
        <p>商品の状態: {{ $item->item_state }}</p>
    </div>
    <div class="item-detail__comment">
        <h3>コメント ({{ count($item->comments) }})</h3>
        @if($item->comments->count() > 0)
        @foreach ($item->comments as $comment)
        <div class="comment-item">
            <div class="comment-user">
                <div class="comment-user__icon">
                    <img src="{{ asset($comment->user->profile_image ?? '') }}" alt="user-icon">
                </div>
                <span class="comment-user__name">{{ $comment->user->name }}</span>
            </div>
            <div class="comment-text-box">
                <p>{{ $comment->comment_text }}</p>
            </div>
        </div>
        @endforeach
        @else
        <p>まだコメントはありません。</p>
        @endif
        <form action="/comment/{{ $item->id }}" method="POST">
            @csrf
            <textarea name="text" rows="4" cols="50"></textarea>
            <button type="submit">コメントを送信する</button>
        </form>
    </div>
</div>
@endsection