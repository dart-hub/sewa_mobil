<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

// Route untuk autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk dashboard (menggunakan welcome.blade.php)
Route::middleware(['auth'])->get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ========================================
// RUTE KHUSUS ADMIN (dilindungi middleware 'auth' + 'admin')
// ========================================
Route::middleware(['auth', 'admin'])->group(function () {
    // Mobil - HANYA ADMIN
    Route::get('/mobils/create', [MobilController::class, 'create'])->name('mobils.create');
    Route::post('/mobils', [MobilController::class, 'store'])->name('mobils.store');
    Route::get('/mobils/{mobil}/edit', [MobilController::class, 'edit'])->name('mobils.edit');
    Route::put('/mobils/{mobil}', [MobilController::class, 'update'])->name('mobils.update');
    Route::delete('/mobils/{mobil}', [MobilController::class, 'destroy'])->name('mobils.destroy');
    
    // Customer - HANYA ADMIN
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    
    // Stok - HANYA ADMIN (semua operasi)
    Route::get('/stoks/create', [StokController::class, 'create'])->name('stoks.create');
    Route::post('/stoks', [StokController::class, 'store'])->name('stoks.store');
    Route::get('/stoks/{stok}/edit', [StokController::class, 'edit'])->name('stoks.edit');
    Route::put('/stoks/{stok}', [StokController::class, 'update'])->name('stoks.update');
    Route::delete('/stoks/{stok}', [StokController::class, 'destroy'])->name('stoks.destroy');
    
    // Transaksi - ADMIN bisa edit dan hapus
    Route::get('/transaksis/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksis.edit');
    Route::put('/transaksis/{transaksi}', [TransaksiController::class, 'update'])->name('transaksis.update');
    Route::delete('/transaksis/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksis.destroy');
});

// ========================================
// RUTE UNTUK ADMIN DAN KASIR (dilindungi middleware 'auth saja)
// ========================================
Route::middleware(['auth'])->group(function () {
    // Mobil - ADMIN dan KASIR bisa lihat
    Route::get('/mobils', [MobilController::class, 'index'])->name('mobils.index');
    Route::get('/mobils/{mobil}', [MobilController::class, 'show'])->name('mobils.show');
    
    // Stok - ADMIN dan KASIR bisa lihat
    Route::get('/stoks', [StokController::class, 'index'])->name('stoks.index');
    Route::get('/stoks/{stok}', [StokController::class, 'show'])->name('stoks.show');
    
    // Transaksi - ADMIN dan KASIR bisa lihat, buat, dan detail
    Route::get('/transaksis', [TransaksiController::class, 'index'])->name('transaksis.index');
    Route::get('/transaksis/create', [TransaksiController::class, 'create'])->name('transaksis.create');
    Route::post('/transaksis', [TransaksiController::class, 'store'])->name('transaksis.store');
    Route::get('/transaksis/{transaksi}', [TransaksiController::class, 'show'])->name('transaksis.show');
});
