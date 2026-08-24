<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactStore'])->name('contact.store');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [HomeController::class, 'blogShow'])->name('blog.show');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');

Route::post('/inquiry/store', [FrontendController::class, 'storeInquiry'])
    ->name('inquiry.store');

Route::get('/inquiry/track', [FrontendController::class, 'trackForm'])->name('inquiry.track.form');
Route::post('/inquiry/track', [FrontendController::class, 'track'])->name('inquiry.track');
Route::get('/inquiry/thank-you/{reference}', [FrontendController::class, 'thankYou'])->name('inquiry.thankyou');

Route::match(['GET', 'POST'], '/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])
        ->name('customer.dashboard');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/inquiry/read/{id}', [AdminController::class, 'markRead'])
        ->name('inquiry.read');

    Route::get('/inquiry/read-all', [AdminController::class, 'markAllRead'])
        ->name('inquiry.readAll');
        
    Route::get('/inquiry/delete/{id}', [AdminController::class, 'delete'])
        ->name('inquiry.delete');

    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

    Route::get('/blogs', [AdminController::class, 'blogs'])->name('blogs');
    Route::post('/blogs', [AdminController::class, 'storeBlog'])->name('blogs.store');
    Route::get('/blogs/{id}/edit', [AdminController::class, 'editBlog'])->name('blogs.edit');
    Route::put('/blogs/{id}', [AdminController::class, 'updateBlog'])->name('blogs.update');
    Route::delete('/blogs/{id}', [AdminController::class, 'destroyBlog'])->name('blogs.destroy');

    Route::get('/testimonials', [AdminController::class, 'testimonials'])->name('testimonials');
    Route::post('/testimonials', [AdminController::class, 'storeTestimonial'])->name('testimonials.store');
    Route::get('/testimonials/{id}/edit', [AdminController::class, 'editTestimonial'])->name('testimonials.edit');
    Route::put('/testimonials/{id}', [AdminController::class, 'updateTestimonial'])->name('testimonials.update');
    Route::delete('/testimonials/{id}', [AdminController::class, 'destroyTestimonial'])->name('testimonials.destroy');

    Route::get('/faqs', [AdminController::class, 'faqs'])->name('faqs');
    Route::post('/faqs', [AdminController::class, 'storeFaq'])->name('faqs.store');
    Route::get('/faqs/{id}/edit', [AdminController::class, 'editFaq'])->name('faqs.edit');
    Route::put('/faqs/{id}', [AdminController::class, 'updateFaq'])->name('faqs.update');
    Route::delete('/faqs/{id}', [AdminController::class, 'destroyFaq'])->name('faqs.destroy');
});
