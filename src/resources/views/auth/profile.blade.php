@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="mypage__content">
    <div class="mypage__user-info">
        <div class="user-info__flex">
            <div class="user-info">
                <div class="user-info__image">
                    @if($user->profile_image)
                    <img src="{{ asset($user->profile_image) }}" alt="ユーザーアイコン">
                    @else
                    <div class="user-info__image-default"></div>
                    @endif
                </div>
                <h2 class="user-info__name">{{ $user->user_name ?? $user->name }}</h2>
            </div>
            <a href="/mypage/profile" class="user-info__edit-btn">プロフィールを編集</a>
        </div>
    </div>

    <div class="form__header">
        <div class="form__header-link">
            <a href="/mypage?page=sell" class="product__heading-btn {{ $tab !== 'buy' ? 'active' : '' }}">出品した商品</a>
            <a href="/mypage?page=buy" class="product__heading-btn {{ $tab === 'buy' ? 'active' : '' }}">購入した商品</a>
        </div>
    </div>

    <div class="form__content">
        <div class="product-form__group">
            @forelse($items as $item)
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
            @empty
            <div class="mypage__empty">
                <p>{{ $tab === 'buy' ? '購入した商品はまだありません' : '出品した商品はまだありません' }}</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection