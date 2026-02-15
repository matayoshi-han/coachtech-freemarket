@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css')}}">
@endsection

@section('content')
<div class="sell__content">
    <div class="sell__header">
        <h2>商品の出品</h2>
    </div>

    <form action="/sell" method="POST" enctype="multipart/form-data" class="sell__form">
        @csrf
        <div class="sell__section">
            <label class="sell__label">商品画像</label>
            <div class="sell__image-upload-container">
                <input type="file" name="image" id="image" accept="image/*" class="sell__image-input">
                <label for="image" class="sell__image-btn">画像を選択する</label>
                <p class="sell__error">@error('image') {{ $message }} @enderror</p>
            </div>
        </div>

        <div class="sell__section">
            <h3 class="sell__sub-heading">商品の詳細</h3>
            <div class="sell__group">
                <label for="categories" class="sell__label">カテゴリー</label>
                <div class="sell__category-list">
                    @foreach($categories as $category)
                    <div class="category-item">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat-{{ $category->id }}">
                        <label for="cat-{{ $category->id }}">{{ $category->category_name }}</label>
                    </div>
                    @endforeach
                </div>
                <p class="sell__error">@error('categories') {{ $message }} @enderror</p>
            </div>

            <div class="sell__group">
                <label for="condition" class="sell__label">商品の状態</label>
                <select name="condition" id="condition" class="sell__select">
                    <option value="" disabled selected>選択してください</option>
                    <option value="良好">良好</option>
                    <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                    <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                    <option value="状態が悪い">状態が悪い</option>
                </select>
                <p class="sell__error">@error('condition') {{ $message }} @enderror</p>
            </div>
        </div>

        <div class="sell__section">
            <h3 class="sell__sub-heading">商品名と説明</h3>
            <div class="sell__group">
                <label for="item_name" class="sell__label">商品名</label>
                <input type="text" name="item_name" id="item_name" class="sell__input" value="{{ old('item_name') }}">
                <p class="sell__error">@error('item_name') {{ $message }} @enderror</p>
            </div>

            <div class="sell__group">
                <label for="brand_name" class="sell__label">ブランド名</label>
                <input type="text" name="brand_name" id="brand_name" class="sell__input" value="{{ old('brand_name') }}">
                <p class="sell__error">@error('brand_name') {{ $message }} @enderror</p>
            </div>

            <div class="sell__group">
                <label for="item_description" class="sell__label">商品の説明</label>
                <textarea name="item_description" id="item_description" rows="5" class="sell__textarea">{{ old('item_description') }}</textarea>
                <p class="sell__error">@error('item_description') {{ $message }} @enderror</p>
            </div>
        </div>

        <div class="sell__section">
            <h3 class="sell__sub-heading">販売価格</h3>
            <div class="sell__group">
                <label for="item_amount" class="sell__label">販売価格</label>
                <div class="price-input-container">
                    <span class="currency-unit">¥</span>
                    <input type="number" name="item_amount" id="item_amount" class="sell__input" value="{{ old('item_amount') }}">
                </div>
                <p class="sell__error">@error('item_amount') {{ $message }} @enderror</p>
            </div>
        </div>

        <div class="sell__actions">
            <button type="submit" class="sell__submit-btn">出品する</button>
        </div>
    </form>
</div>
@endsection