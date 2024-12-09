<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


Auth::routes([
    'register' => false,
    'reset' => false,
]);

// main sin middleware
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
})->name('main');

// Middleware para todos rutas
Route::middleware(['auth', 'check_active'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('/users', UsuarioController::class)->names("users");
    Route::post('/product/find', [ProductoController::class, 'find'])->name("product.find");
    Route::resource('/product', ProductoController::class)->names("product");
});

