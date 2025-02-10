<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('index');
})->name('index');

// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// })->name('dashboard');

// Route::get('/login', function () {
//     return view('admin.login');
// })->name('login');

// Route::get('/register', function () {
//     return view('admin.register');
// })->name('register');

Route::get('/forgot-password', function () {
    return view('admin.forgot-password');
})->name('forgot-password');

Route::get('/charts', function () {
    return view('admin.charts');
})->name('charts');

Route::get('/table', function () {
    return view('admin.table');
})->name('table');


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
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
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});