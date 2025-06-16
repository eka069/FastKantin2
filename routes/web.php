<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SellerController;

//dashboard
Route::resource('dashboard', DashboardController::class);


// Halaman utama
Route::get('/', [OrderController::class, 'index'])->name('home');
Route::get('/menu-user/{id}', [OrderController::class, 'show'])->name('detail');
Route::resource('menu', MenuController::class);
Route::resource('category', CategoryController::class);

// Produk dan order
Route::resource('order', OrderController::class);
Route::resource('produk', ProdukController::class);
Route::resource('cart', CartController::class);
Route::get('/cart', [CartController::class, 'index'])->name('keranjang');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'showForm']);
Route::post('/checkout', [CheckoutController::class, 'submit']);

// Autentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// Seller routes (dalam middleware)
Route::middleware(['auth', 'isSeller'])->group(function () {
    Route::get('/seller', [SellerController::class, 'index'])->name('seller.index');
    Route::get('/seller/tambah', [SellerController::class, 'create'])->name('seller.create');
    Route::post('/seller/tambah', [SellerController::class, 'store'])->name('seller.store');
    Route::get('/seller/edit/{id}', [SellerController::class, 'edit'])->name('seller.edit');
    Route::post('/seller/edit/{id}', [SellerController::class, 'update'])->name('seller.update');
    Route::post('/seller/hapus/{id}', [SellerController::class, 'destroy'])->name('seller.destroy');
});

// Halaman tambahan
Route::view('/profil', 'profile');
Route::get('/tes', fn() => 'Tes berhasil!');

