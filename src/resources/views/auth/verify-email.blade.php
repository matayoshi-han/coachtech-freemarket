@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="verify-email__container">
    <h2>登録ありがとうございます！</h2>
    <p>現在、仮登録の状態です。</p>
    <p>ご指定のメールアドレスに認証メールを送信しました。<br>
        メール内のリンクをクリックして、本登録を完了させてください。</p>

    @if (session('message'))
    <p class="success-message">{{ session('message') }}</p>
    @endif

    <div class="verify-email__actions">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <p>もしメールが届かない場合は、下のボタンをクリックしてください。</p>
            <button type="submit" class="btn">認証メールを再送信する</button>
        </form>
    </div>
</div>
@endsection