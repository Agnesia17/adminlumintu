<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/login', function () {
    return view('admin.login');
})->name('login');

Route::get('/register', function () {
    return view('admin.register');
})->name('register');

Route::get('/forgot-password', function () {
    return view('admin.forgot-password');
})->name('forgot-password');

Route::get('/charts', function () {
    return view('admin.charts');
})->name('charts');

Route::get('/table', function () {
    return view('admin.table');
})->name('table');
