@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css')}}">
@endsection

@section('content')
<div class="item-detail__container">
    <div class="item-detail__image">
        <img src="{{ asset($item->image_url) }}" alt="{{ $item->item_name }}">
    </div>

    <div class="item-detail__info-area">
        <div class="item-detail__info">
            <h2>{{ $item->item_name }}</h2>
            <p>{{ $item->item_brand ?? '' }}</p>
            <p class="item-detail__price">¥{{ number_format($item->item_amount) }}（税込）</p>

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
                    <span class="action-count">{{ $item->comments->count() }}</span>
                </div>
            </div>
        </div>

        <a class="btn" href="/purchase/{{ $item->id }}">購入手続きへ</a>

        <div class="item-detail__description">
            <h3>商品説明</h3>
            <p>{{ $item->item_description }}</p>
            <h3>商品の情報</h3>
            <div class="item-detail__description-category">
                <h4>カテゴリー:</h4>
                @foreach($item->categories as $category)
                <span class="category-tag">{{ $category->category_name }}</span>
                @endforeach
            </div>
            <div class="item-detail__description-state">
                <h4>商品の状態:</h4>
                <p>{{ $item->item_state }}</p>
            </div>
        </div>

        <div class="item-detail__comment">
            <h3>コメント ({{ $item->comments->count() }})</h3>
            @foreach ($item->comments as $comment)
            <div class="comment-item">
                <div class="comment-user">
                    <div class="comment-user__icon">
                        @if($comment->user->profile_image)
                        <img src="{{ asset($comment->user->profile_image) }}" alt="user-icon">
                        @else
                        <div class="user-info__image-default"></div>
                        @endif
                    </div>
                    <span class="comment-user__name">{{ $comment->user->user_name ?? $comment->user->name }}</span>
                </div>
                <div class="comment-text-box">
                    <p class="comment-text">{{ $comment->comment_text }}</p>
                </div>
            </div>
            @endforeach

            <form action="/comment/{{ $item->id }}" method="POST" class="comment-form">
                @csrf
                <textarea name="comment_text" rows="4" class="comment-textarea"></textarea>
                <button class="btn comment-submit-btn" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection