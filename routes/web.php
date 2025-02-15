<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanLabaController;
use App\Http\Controllers\LaporanPembelianController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('index');
})->name('index');


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::get('/forgot-password', [AuthController::class, 'showForgetPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    // Halaman notice verifikasi email
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // Handle verifikasi email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        Auth::logout();
        return redirect()->route('login')
            ->with('success', 'Email berhasil diverifikasi! Silakan login dengan akun Anda.');
    })->middleware('signed')->name('verification.verify');

    // Kirim ulang email verifikasi
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Link verifikasi telah dikirim!');
    })->middleware('throttle:6,1')->name('verification.resend');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/penjualan', function () {
        return view('admin.Laporan.penjualan');
    })->name('penjualan');


    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/addproduct', [ProductController::class, 'create'])->name('product.addproduct');
    Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/pembelian', [LaporanPembelianController::class, 'index'])->name('pembelian');
    Route::post('/pembelian', [LaporanPembelianController::class, 'store'])->name('pembelian.store');
    Route::get('/pembelian/add-pembelian', [LaporanPembelianController::class, 'create'])->name('pembelian.add-pembelian');
    Route::get('/pembelian/preview/{id}', [LaporanPembelianController::class, 'downloadNota'])->name('pembelian.preview');
    Route::get('/pembelian/download/{id}', [LaporanPembelianController::class, 'downloadNotaFile'])->name('pembelian.download');

    Route::get('/laba', [LaporanLabaController::class, 'index'])->name('laba');
    Route::get('/laba/export', [LaporanLabaController::class, 'export'])->name('laba.export');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
