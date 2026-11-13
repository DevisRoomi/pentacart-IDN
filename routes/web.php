<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Buyer\ShopCatalog;
use App\Livewire\Merchant\OrderHistory;
use App\Livewire\Merchant\ProfileSettings;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman Utama Publik
Route::get('/', function (Request $request) {
    $search = trim((string) $request->query('q', ''));

    $merchants = Merchant::query()
        ->with(['user', 'products' => function ($q) {
            $q->where('is_available', true)->take(4);
        }])
        ->withCount(['products' => function ($q) {
            $q->where('is_available', true);
        }])
        ->search($search)
        ->latest()
        ->get();

    return view('welcome', compact('merchants', 'search'));
})->name('home');

// Buyer Public Catalog & Order Flow (Fitur Apip)
Route::get('/lapak/{merchant:slug}', ShopCatalog::class)->name('buyer.shop');
Route::get('/shop/{merchant:slug}', ShopCatalog::class)->name('shop.catalog');

// Guest Auth Routes (Livewire Murni Tanpa Breeze)
Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

// Merchant Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/merchant/profile', ProfileSettings::class)->name('merchant.profile');
    Route::get('/merchant/orders', OrderHistory::class)->name('merchant.orders');

    // Placeholder aman sampai modul ProductManager milik Ahmad di-merge ke main
    Route::get('/merchant/products', function () {
        $merchant = Auth::user()->merchant;
        return view('merchant.products-placeholder', compact('merchant'));
    })->name('merchant.products');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    })->name('logout');
});
