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

                {{-- カード入力エリア --}}
                <div id="stripe-area" style="display: none; margin-top: 20px;">
                    <label for="card-element" style="margin-bottom: 10px; display: block; font-weight: bold;">カード情報</label>
                    <div id="card-element" style="border: 1px solid #ddd; padding: 12px; border-radius: 4px; background: #fff;"></div>
                    <div id="card-errors" role="alert" style="color: #ff4d4d; font-size: 14px; margin-top: 5px;"></div>
                </div>

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
                        <td id="display-payment">選択してください</td>
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

{{-- スクリプトを最後に一箇所にまとめる --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
    // 1. Stripe初期化
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const card = elements.create('card', {
        hidePostalCode: true // 日本では郵便番号入力を隠すのが一般的
    });

    const select = document.getElementById('payment_method');
    const display = document.getElementById('display-payment');
    const stripeArea = document.getElementById('stripe-area');
    const form = document.querySelector('.purchase__form');

    // 2. 支払い方法の選択変更イベント
    select.addEventListener('change', () => {
        const selectedValue = select.value;

        // サイドバーの表示を更新
        display.textContent = select.options[select.selectedIndex].text;

        // カード払いなら入力欄を表示、それ以外は非表示
        if (selectedValue === 'credit_card') {
            stripeArea.style.display = 'block';
            card.mount('#card-element');
        } else {
            stripeArea.style.display = 'none';
            card.unmount();
        }
    });

    // 3. フォーム送信イベント
    form.addEventListener('submit', async (event) => {
        if (select.value === 'credit_card') {
            event.preventDefault(); // カード払いの時は一旦止めてトークンを取得する

            const {
                token,
                error
            } = await stripe.createToken(card);

            if (error) {
                // エラーがあれば表示
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                // 既存のトークンがあれば削除（念のため）
                const oldToken = document.querySelector('input[name="stripeToken"]');
                if (oldToken) oldToken.remove();

                // トークンを隠しフィールドに追加して送信
                const hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        }
    });
</script>
@endsection