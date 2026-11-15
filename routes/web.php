<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Buyer\ShopCatalog;
use App\Livewire\Merchant\OrderHistory;
use App\Livewire\Merchant\ProfileSettings;
use App\Models\ImageBlob;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman Utama Publik
Route::get('/', function (Request $request) {
    $search = trim((string) $request->input('q', ''));
    $openOnly = $request->boolean('open_only');

    $merchants = Merchant::query()
        ->with([
            'qrisImageBlob:id,merchant_id,content_hash',
            'products' => function ($q) {
                $q->where('is_available', true)
                    ->with('imageBlob:id,product_id,content_hash')
                    ->latest();
            },
        ])
        ->withCount(['products' => function ($q) {
            $q->where('is_available', true);
        }])
        ->search($search)
        ->latest()
        ->get();

    if ($openOnly) {
        $merchants = $merchants->filter(function ($merchant) {
            $status = $merchant->operationalStatus();
            return $status['open'] === true;
        })->values();
    }

    return view('welcome', compact('merchants', 'search', 'openOnly'));
})->name('home');

Route::get('/images/{imageBlob}', function (Request $request, ImageBlob $imageBlob) {
    $version = $request->query('v');

    abort_unless(is_string($version) && hash_equals($imageBlob->content_hash, $version), 404);
    abort_unless(in_array($imageBlob->mime_type, ['image/jpeg', 'image/png', 'image/webp'], true), 404);

    return response($imageBlob->content)
        ->header('Content-Type', $imageBlob->mime_type)
        ->header('Content-Disposition', 'inline')
        ->header('Cache-Control', 'public, max-age=31536000, immutable')
        ->header('ETag', '"'.$imageBlob->content_hash.'"')
        ->header('X-Content-Type-Options', 'nosniff');
})->whereNumber('imageBlob')->name('images.show');

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
    Route::livewire('/merchant/products', 'merchant.product-manager')->name('merchant.products');
    Route::get('/merchant/orders', OrderHistory::class)->name('merchant.orders');

    
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    })->name('logout');
});
