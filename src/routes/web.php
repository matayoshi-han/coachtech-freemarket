<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/', [ItemController::class, 'index'])->name('index');
Route::get('/item/{id}', [ItemController::class, 'show'])->name('items.show');

Route::middleware('auth')->group(
    function () {
        Route::get('/mypage', [AuthController::class, 'showProfile'])->name('mypage');
        Route::get('/mypage/profile', [AuthController::class, 'editProfile'])->name('mypage.profile.edit');
        Route::post('/mypage/profile', [AuthController::class, 'updateProfile'])->name('mypage.profile.update');
        Route::post('/like/{id}', [ItemController::class, 'toggleLike'])->name('like.toggle');
        Route::post('/comment/{id}', [ItemController::class, 'storeComment'])->name('items.storeComment');
        Route::get('/purchase/{id}', [ItemController::class, 'purchase'])->name('items.purchase');
        Route::post('/purchase/{id}', [ItemController::class, 'storeOrder'])->name('thankyou');
        Route::get('/purchase/address/{id}', [ItemController::class, 'editAddress'])->name('purchase.address');
        Route::post('/purchase/address/{id}', [ItemController::class, 'updateAddress'])->name('purchase.address.update');
        Route::get('/sell', [ItemController::class, 'create'])->name('items.create');
        Route::post('/sell', [ItemController::class, 'store'])->name('items.store');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    }
);