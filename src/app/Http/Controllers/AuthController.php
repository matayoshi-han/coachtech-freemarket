<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;

class AuthController extends Controller
{
    //会員登録画面の表示
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    //会員登録処理
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        Auth::login($user);
        return redirect('/mypage/profile');
    }

    //ログイン画面の表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    //ログイン処理
    public function login(LoginRequest $request)
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

    //プロフィール画面の表示
    public function showProfile(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('page', 'sell');

        if ($tab === 'buy') {
            $items = Item::whereHas('order', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->get();
        } else {

            $items = Item::where('user_id', $user->id)->get();
        }

        return view('auth.profile', compact('user', 'items', 'tab'));
    }

    //プロフィール編集画面の表示
    public function editProfile()
    {
        $user = Auth::user();
        return view('auth.edit_profile', compact('user'));
    }

    //プロフィール更新処理
    public function updateProfile(ProfileRequest $request)
    {
        $user = \App\Models\User::find(Auth::id());
        $user->name = $request->input('name');
        $user->postal_code = $request->input('postal_code');
        $user->address = $request->input('address');
        $user->building = $request->input('building');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profiles', 'public');
            $user->profile_image = 'storage/' . $path;
        }

        $user->save();

        return redirect('/')->with('success', 'プロフィールを更新しました。');
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
