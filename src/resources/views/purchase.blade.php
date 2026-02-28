@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css')}}">
@endsection

@section('content')
<div class="purchase__container">
    <form action="{{ route('thankyou', $item->id) }}" method="POST" class="purchase__form">
        @csrf
        <div class="purchase__main">
            <div class="purchase__item-info">
                <div class="purchase__item-image">
                    <img src="{{ asset($item->image_url) }}" alt="{{ $item->item_name }}">
                </div>
                <div class="purchase__item-detail">
                    <h1>{{ $item->item_name }}</h1>
                    <p class="purchase__price">¥{{ number_format($item->item_amount) }}</p>
                </div>
            </div>

            <div class="purchase__section">
                <div class="purchase__section-header">
                    <h2>支払い方法</h2>
                </div>
                <select name="payment_method" id="payment_method" class="purchase__select">
                    <option value="" disabled selected>選択してください</option>
                    <option value="convenience_store">コンビニ払い</option>
                    <option value="credit_card">カード払い</option>
                </select>
                @error('payment_method')
                <p style="color: #ff4d4d;">{{ $message }}</p>
                @enderror
            </div>

            <div class="purchase__section">
                <div class="purchase__section-header">
                    <h2>配送先</h2>
                    <a href="{{ route('purchase.address', $item->id) }}" class="purchase__link">変更する</a>
                </div>
                <div class="purchase__address-info">
                    <p>〒 {{ $user->postal_code }}</p>
                    <p>{{ $user->address }} {{ $user->building }}</p>
                </div>
                @error('shipping_postal_code')
                <p style="color: #ff4d4d;">配送先を設定してください（郵便番号）</p>
                @enderror
                @error('shipping_address')
                <p style="color: #ff4d4d;">配送先を設定してください（住所）</p>
                @enderror
            </div>
        </div>

        <div class="purchase__side">
            <div class="purchase__confirm-box">
                <table class="purchase__table">
                    <tr class="purchase__table-row">
                        <th>商品代金</th>
                        <td>¥{{ number_format($item->item_amount) }}</td>
                    </tr>
                    <tr class="purchase__table-row">
                        <th>支払い方法</th>
                        <td id="display-payment">コンビニ払い</td>
                    </tr>
                </table>
                <input type="hidden" name="shipping_postal_code" value="{{ $user->postal_code }}">
                <input type="hidden" name="shipping_address" value="{{ $user->address }}">
                <input type="hidden" name="shipping_building" value="{{ $user->building }}">
                <button type="submit" class="purchase__submit-btn">購入する</button>
            </div>
        </div>
    </form>
</div>

<script>
    const select = document.getElementById('payment_method');
    const display = document.getElementById('display-payment');
    select.addEventListener('change', () => {
        display.textContent = select.options[select.selectedIndex].text;
    });
</script>
@endsection