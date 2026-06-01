<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $search = $request->search;

        $inquiries = Inquiry::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->get();

        $total = Inquiry::count();

        $read = Inquiry::where('is_read', true)->count();

        $unread = Inquiry::where('is_read', false)->count();

        $today = Inquiry::whereDate(
            'created_at',
            Carbon::today()
        )->count();

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
        Inquiry::findOrFail($id)->update([
            'is_read' => true
        ]);

        return back()->with(
            'success',
            'Inquiry marked as read successfully.'
        );
    }

    public function delete($id)
    {
        Inquiry::findOrFail($id)->delete();

        return back()->with(
            'success',
            'Inquiry deleted successfully.'
        );
    }
}