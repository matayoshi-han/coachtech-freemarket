@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit_profile.css') }}">
@endsection

@section('content')
<div class="profile__content">
    <div class="profile__header">
        <h2>プロフィール設定</h2>
    </div>

    <form action="/mypage/profile" method="POST" enctype="multipart/form-data" class="profile__form">
        @csrf

        <div class="profile__section">
            <div class="profile__image-group">
                <div class="profile__image-preview">
                    @if(Auth::user()->profile_image)
                    <img src="{{ asset(Auth::user()->profile_image) }}" alt="ユーザーアイコン" id="preview">
                    @else
                    <div class="profile__image-default" id="preview-default"></div>
                    @endif
                </div>
                <label for="image" class="profile__image-btn">画像を選択する</label>
                <input type="file" name="image" id="image" accept="image/*" class="profile__image-input">
            </div>
            <p class="profile__error">@error('image') {{ $message }} @enderror</p>
        </div>

        <div class="profile__group">
            <label for="name" class="profile__label">ユーザー名</label>
            <input type="text" name="name" id="name" class="profile__input" value="{{ old('name', $user->name) }}">
            <p class="profile__error">@error('name') {{ $message }} @enderror</p>
        </div>

        <div class="profile__group">
            <label for="postal_code" class="profile__label">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" class="profile__input" value="{{ old('postal_code', $user->postal_code) }}">
            <p class="profile__error">@error('postal_code') {{ $message }} @enderror</p>
        </div>

        <div class="profile__group">
            <label for="address" class="profile__label">住所</label>
            <input type="text" name="address" id="address" class="profile__input" value="{{ old('address', $user->address) }}">
            <p class="profile__error">@error('address') {{ $message }} @enderror</p>
        </div>

        <div class="profile__group">
            <label for="building" class="profile__label">建物名</label>
            <input type="text" name="building" id="building" class="profile__input" value="{{ old('building', $user->building) }}">
            <p class="profile__error">@error('building') {{ $message }} @enderror</p>
        </div>

        <div class="profile__actions">
            <button type="submit" class="profile__submit-btn">更新する</button>
        </div>
    </form>
</div>
@endsection