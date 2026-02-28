@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address__content">
    <div class="address__header">
        <h2>住所の変更</h2>
    </div>
    <form action="{{ route('purchase.address.update', $item->id) }}" method="POST" class="address__form">
        @csrf
        <div class="address__group">
            <label for="postal_code">郵便番号</label>
            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}">
            @error('postal_code')
                <div class="address__error">{{ $message }}</div>
            @enderror
        </div>
        <div class="address__group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}">
            @error('address')
                <div class="address__error">{{ $message }}</div>
            @enderror
        </div>
        <div class="address__group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $user->building) }}">
                @error('building')
                    <div class="address__error">{{ $message }}</div>
                @enderror
        </div>
        <button type="submit" class="address__submit-btn">更新する</button>
    </form>
</div>
@endsection