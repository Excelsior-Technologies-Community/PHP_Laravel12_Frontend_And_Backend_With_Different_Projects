<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $inquiries = Inquiry::query()
            ->with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('reference_number', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                if ($status === 'read') {
                    $query->where('is_read', true);
                } elseif ($status === 'unread') {
                    $query->where('is_read', false);
                } elseif (in_array($status, ['pending', 'in_progress', 'resolved', 'closed'])) {
                    $query->where('status', $status);
                }
            })
            ->orderByDesc('id')
            ->paginate(10);

        $total = Inquiry::count();
        $read = Inquiry::where('is_read', true)->count();
        $unread = Inquiry::where('is_read', false)->count();
        $today = Inquiry::whereDate('created_at', Carbon::today())->count();

        return view('backend.dashboard', compact(
            'inquiries',
            'total',
            'read',
            'unread',
            'today'
        ));
    }

    public function markRead($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Inquiry marked as read.');
    }

    public function markAllRead()
    {
        Inquiry::where('is_read', false)->update(['is_read' => true]);
        return redirect()->back()->with('success', 'All inquiries marked as read.');
    }

    public function delete($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        $inquiry->delete();
        return redirect()->back()->with('success', 'Inquiry deleted.');
    }

    public function categories(Request $request)
    {
        $categories = Category::latest()->get();
        return view('backend.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return back()->with('edit_category', $category);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return back()->with('success', 'Category updated successfully.');
    }

    public function destroyCategory($id)
    {
        Category::findOrFail($id)->delete();
        return back()->with('success', 'Category deleted.');
    }

    public function blogs(Request $request)
    {
        $blogs = Blog::latest()->get();
        return view('backend.blogs', compact('blogs'));
    }

    public function storeBlog(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'author' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $blog = Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'author' => $request->author ?? auth()->user()->name,
            'is_published' => $request->has('is_published'),
        ]);

        if ($request->hasFile('featured_image')) {
            $blog->update([
                'featured_image' => $request->file('featured_image')->store('blogs', 'public'),
            ]);
        }

        return back()->with('success', 'Blog created successfully.');
    }

    public function editBlog($id)
    {
        $blog = Blog::findOrFail($id);
        return back()->with('edit_blog', $blog);
    }

    public function updateBlog(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string',
            'author' => 'nullable|string',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $blog->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . $blog->id,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'author' => $request->author ?? $blog->author,
            'is_published' => $request->has('is_published'),
        ]);

        if ($request->hasFile('featured_image')) {
            $blog->update([
                'featured_image' => $request->file('featured_image')->store('blogs', 'public'),
            ]);
        }

        return back()->with('success', 'Blog updated successfully.');
    }

    public function destroyBlog($id)
    {
        Blog::findOrFail($id)->delete();
        return back()->with('success', 'Blog deleted.');
    }

    public function testimonials(Request $request)
    {
        $testimonials = Testimonial::latest()->get();
        return view('backend.testimonials', compact('testimonials'));
    }

    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $testimonial = Testimonial::create([
            'name' => $request->name,
            'position' => $request->position,
            'company' => $request->company,
            'message' => $request->message,
            'rating' => $request->rating ?? 5,
        ]);

        if ($request->hasFile('avatar')) {
            $testimonial->update([
                'avatar' => $request->file('avatar')->store('testimonials', 'public'),
            ]);
        }

        return back()->with('success', 'Testimonial created successfully.');
    }

    public function editTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return back()->with('edit_testimonial', $testimonial);
    }

    public function updateTestimonial(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $testimonial->update([
            'name' => $request->name,
            'position' => $request->position,
            'company' => $request->company,
            'message' => $request->message,
            'rating' => $request->rating ?? 5,
        ]);

        if ($request->hasFile('avatar')) {
            $testimonial->update([
                'avatar' => $request->file('avatar')->store('testimonials', 'public'),
            ]);
        }

        return back()->with('success', 'Testimonial updated successfully.');
    }

    public function destroyTestimonial($id)
    {
        Testimonial::findOrFail($id)->delete();
        return back()->with('success', 'Testimonial deleted.');
    }

    public function faqs(Request $request)
    {
        $faqs = Faq::orderBy('sort_order')->get();
        return view('backend.faqs', compact('faqs'));
    }

    public function storeFaq(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'FAQ created successfully.');
    }

    public function editFaq($id)
    {
        $faq = Faq::findOrFail($id);
        return back()->with('edit_faq', $faq);
    }

    public function updateFaq(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'category' => $request->category,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return back()->with('success', 'FAQ updated successfully.');
    }

    public function destroyFaq($id)
    {
        Faq::findOrFail($id)->delete();
        return back()->with('success', 'FAQ deleted.');
    }
}
