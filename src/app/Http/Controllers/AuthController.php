<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    //会員登録画面の表示
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    //ログイン画面の表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //ログアウト
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
