<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Testimonial;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('categories', Category::where('is_active', true)->get());
            $view->with('testimonials', Testimonial::where('is_active', true)->latest()->take(3)->get());
            $view->with('locale', session('locale', 'en'));
            $view->with('lang', function ($key) {
                $locale = session('locale', 'en');
                $file = lang_path("{$locale}/messages.php");
                $translations = file_exists($file) ? require $file : [];
                return $translations[$key] ?? $key;
            });
        });
    }
}
