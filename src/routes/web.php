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
        Route::post('/like/{id}', [ItemController::class, 'toggleLike'])->name('like.toggle');
        Route::post('/comment/{id}', [ItemController::class, 'storeComment'])->name('items.storeComment');
        Route::get('/purchase/{id}', [ItemController::class, 'purchase'])->name('items.purchase');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    }
);