@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="verify-email__container">
    <div class="verify-email__card">
        <h2 class="verify-email__title">登録ありがとうございます！</h2>

        <div class="verify-email__message">
            <p>現在、仮登録の状態です。</p>
            <p>ご指定のメールアドレスに認証メールを送信しました。<br>
                メール内のリンクをクリックして、本登録を完了させてください。</p>
        </div>

        @if (session('message'))
        <p class="verify-email__success">{{ session('message') }}</p>
        @endif

        <div class="verify-email__main-action">
            <a href="http://localhost:8025" target="_blank" class="btn btn-primary">認証はこちらから</a>
            <p class="verify-email__note">※別タブでメール確認画面（MailHog）が開きます</p>
        </div>

        <div class="verify-email__resend">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <p>もしメールが届かない場合は、以下のボタンから再送信してください。</p>
                <button type="submit" class="btn btn-secondary">認証メールを再送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection