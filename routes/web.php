<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\LaporanLabaController;
use App\Http\Controllers\LaporanPembelianController;
use App\Http\Controllers\LaporanPenjualanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Controllers\SuratTugasController;
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


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');

    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/addproduct', [ProductController::class, 'create'])->name('product.addproduct');
    Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/pembelian', [LaporanPembelianController::class, 'index'])->name('pembelian');
    Route::post('/pembelian', [LaporanPembelianController::class, 'store'])->name('pembelian.store');
    Route::get('pembelian/export', [LaporanPembelianController::class, 'export'])->name('pembelian.export');
    Route::get('/pembelian/add-pembelian', [LaporanPembelianController::class, 'create'])->name('pembelian.add-pembelian');
    Route::get('/pembelian/preview/{id}', [LaporanPembelianController::class, 'downloadNota'])->name('pembelian.preview');
    Route::get('/pembelian/download/{id}', [LaporanPembelianController::class, 'downloadNotaFile'])->name('pembelian.download');
    Route::delete('/pembelian/delete/{id}', [LaporanPembelianController::class, 'destroy'])->name('pembelian.destroy');

    Route::get('/penjualan', [LaporanPenjualanController::class, 'index'])->name('penjualan');
    Route::get('/penjualan/add-penjualan', [LaporanPenjualanController::class, 'create'])->name('penjualan.add-penjualan');
    Route::post('/penjualan/store', [LaporanPenjualanController::class, 'store'])->name('penjualan.store');
    Route::get('/penjualan/export', [LaporanPenjualanController::class, 'export'])->name('penjualan.export');
    Route::get('/penjualan/preview/{id}', [LaporanPenjualanController::class, 'previewNota'])->name('penjualan.preview');
    Route::get('/penjualan/download/{id}', [LaporanPenjualanController::class, 'downloadNotaFile'])->name('penjualan.download');
    Route::delete('/penjualan/delete/{id}', [LaporanPenjualanController::class, 'destroy'])->name('penjualan.destroy');

    Route::get('/laba', [LaporanLabaController::class, 'index'])->name('laba');
    Route::get('/laba/export', [LaporanLabaController::class, 'export'])->name('laba.export');

    Route::get('/keuangan', [LaporanKeuanganController::class, 'index'])->name('keuangan');
    Route::get('/laporan-keuangan/export', [LaporanKeuanganController::class, 'export'])->name('laporan-keuangan.export');


    Route::get('/surat-tugas', [SuratTugasController::class, 'index'])->name('surat-tugas');
    Route::post('/surat-tugas', [SuratTugasController::class, 'store'])->name('surat-tugas.store');
    Route::get('/surat-tugas/add-surat', [SuratTugasController::class, 'create'])->name('surat-tugas.add-surat');
    Route::get('/surat-tugas/preview/{id}', [SuratTugasController::class, 'preview'])->name('surat-tugas.preview');
    Route::get('/surat-tugas/download/{id}', [SuratTugasController::class, 'download'])->name('surat-tugas.download');
    Route::put('/surat-tugas/update/{id}', [SuratTugasController::class, 'update'])->name('surat-tugas.update');

    Route::get('/surat-jalan', [SuratJalanController::class, 'index'])->name('surat-jalan');
    Route::post('/surat-jalan', [SuratJalanController::class, 'store'])->name('surat-jalan.store');
    Route::get('/surat-jalan/add-surat-jalan', [SuratJalanController::class, 'create'])->name('surat-jalan.add-surat-jalan');
    Route::get('/surat-jalan/preview/{id}', [SuratJalanController::class, 'preview'])->name('surat-jalan.preview');
    Route::get('/surat-jalan/download/{id}', [SuratJalanController::class, 'download'])->name('surat-jalan.download');
    Route::put('/surat-jalan/update/{id}', [SuratJalanController::class, 'update'])->name('surat-jalan.update');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('admin.profile.update');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
