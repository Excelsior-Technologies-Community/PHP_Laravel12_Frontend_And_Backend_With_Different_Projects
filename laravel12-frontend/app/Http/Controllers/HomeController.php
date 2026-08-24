<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        $testimonials = Testimonial::where('is_active', true)->latest()->take(3)->get();
        $blogs = Blog::where('is_published', true)->latest()->take(3)->get();

        return view('frontend.home', compact('categories', 'testimonials', 'blogs'));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function services()
    {
        $categories = Category::where('is_active', true)->get();
        return view('frontend.services', compact('categories'));
    }

    public function faq()
    {
        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();
        return view('frontend.faq', compact('faqs'));
    }

    public function contact()
    {
        $categories = Category::where('is_active', true)->get();
        return view('frontend.contact', compact('categories'));
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }

    public function blog()
    {
        $blogs = Blog::where('is_published', true)->latest()->paginate(9);
        return view('frontend.blog', compact('blogs'));
    }

    public function blogShow($slug)
    {
        $blog = Blog::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('frontend.blog-show', compact('blog'));
    }

    public function testimonials()
    {
        $testimonials = Testimonial::where('is_active', true)->latest()->get();
        return view('frontend.testimonials', compact('testimonials'));
    }
}
