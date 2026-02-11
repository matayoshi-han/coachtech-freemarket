<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::middleware('auth')->group(
    function () {
        Route::get('/', [ItemController::class, 'index'])->name('index');
        Route::get('/item/{id}', [ItemController::class, 'show'])->name('items.show');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    }
);