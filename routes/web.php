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

// Autentikasi
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

//dashboard

// Untuk user biasa
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('home');
    Route::get('/menu-home/{id}', [OrderController::class, 'show'])->name('home-menu.detail');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/riwayat', [OrderController::class, 'history'])->name('riwayat');
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToChart'])->name('add.to.cart');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.delete');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/payment', [OrderController::class, 'payment'])->name('order.payment');
    Route::get('/success', [OrderController::class, 'success'])->name('order.success');
});

// Untuk seller
Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('menu', MenuController::class);
    Route::resource('category', CategoryController::class);
});



// Route::get('/menu-user/{id}', [OrderController::class, 'show'])->name('detail');


// Produk dan order
// Route::resource('order', OrderController::class);
// Route::resource('produk', ProdukController::class);
// Route::resource('cart', CartController::class);
// Route::get('/cart', [CartController::class, 'index'])->name('keranjang');

// Checkout
// Route::get('/checkout', [CheckoutController::class, 'showForm']);
// Route::post('/checkout', [CheckoutController::class, 'submit']);

// Seller routes (dalam middleware)
// Route::middleware(['auth', 'isSeller'])->group(function () {
//     Route::get('/seller', [SellerController::class, 'index'])->name('seller.index');
//     Route::get('/seller/tambah', [SellerController::class, 'create'])->name('seller.create');
//     Route::post('/seller/tambah', [SellerController::class, 'store'])->name('seller.store');
//     Route::get('/seller/edit/{id}', [SellerController::class, 'edit'])->name('seller.edit');
//     Route::post('/seller/edit/{id}', [SellerController::class, 'update'])->name('seller.update');
//     Route::post('/seller/hapus/{id}', [SellerController::class, 'destroy'])->name('seller.destroy');
// });

// Halaman tambahan
// Route::view('/profil', 'profile');


