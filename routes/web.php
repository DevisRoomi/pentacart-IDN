<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Merchant\ProfileSettings;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Halaman Utama Publik
Route::get('/', function () {
    $merchants = Merchant::withCount(['products' => function ($q) {
        $q->where('is_available', true);
    }])->latest()->get();

    return view('welcome', compact('merchants'));
})->name('home');

// Guest Auth Routes (Livewire Murni Tanpa Breeze)
Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

// Merchant Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/merchant/profile', ProfileSettings::class)->name('merchant.profile');

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    })->name('logout');
});
