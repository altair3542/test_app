<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('cart', [CartController::class, 'store'])->name('cart.store');
    Route::delete('cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('checkout', [OrderController::class, 'create'])->name('checkout.create');
    Route::post('checkout', [OrderController::class, 'store'])->name('checkout.store');


});

// Rutas de productos accesibles públicamente
Route::resource('products', ProductController::class);

require __DIR__.'/auth.php';
