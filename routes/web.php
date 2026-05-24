<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\WhatCanIBakeController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\BookmarkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CakePedia — Web Routes (Final dengan Auth & Proteksi Admin)
|--------------------------------------------------------------------------
*/

// [1] AREA TAMU (Belum Login)
// Rute ini hanya bisa diakses kalau user belum login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Redirect root diarahkan ke /recipes (nanti kalau belum login akan ditendang ke /login otomatis)
Route::get('/', fn () => redirect()->route('recipes.index'));

// [2] AREA WAJIB LOGIN (Member & Admin)
// Rute di bawah ini HANYA bisa diakses jika sudah login
Route::middleware(['auth'])->group(function () {
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Fitur Umum (Bisa diakses Member & Admin)
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');
    
    Route::get('/what-can-i-bake', [WhatCanIBakeController::class, 'index'])->name('what-can-i-bake');
    Route::post('/recipes/rate', [RatingController::class, 'store'])->name('ratings.store');
    
    Route::get('/my-bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/recipes/bookmark', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');

    // [3] AREA KHUSUS ADMIN (Proteksi CRUD)
    // Menggunakan class IsAdmin Middleware
    Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {
        // Rute CRUD selain index & show (create, store, edit, update, destroy)
        Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
        Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');
        Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
        Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
        Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');
    });

});