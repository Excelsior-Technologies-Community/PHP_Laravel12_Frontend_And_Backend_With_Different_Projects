<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index']);

Route::post('/inquiry/store', [FrontendController::class, 'storeInquiry'])
    ->name('inquiry.store');

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->name('dashboard');

Route::get('/inquiry/read/{id}', [AdminController::class, 'markRead'])
    ->name('inquiry.read');

Route::get('/inquiry/delete/{id}', [AdminController::class, 'delete'])
    ->name('inquiry.delete');