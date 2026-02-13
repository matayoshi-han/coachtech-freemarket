<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    //会員登録画面の表示
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    //会員登録処理
    public function register(AuthRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        Auth::login($user);
        return redirect('/');
    }

    //ログイン画面の表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //ログイン処理
    public function login(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login_error' => 'ログイン情報が登録されていません。',
        ])->onlyInput('email');
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
