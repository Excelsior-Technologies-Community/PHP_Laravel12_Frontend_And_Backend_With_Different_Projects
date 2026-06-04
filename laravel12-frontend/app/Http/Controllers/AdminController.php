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
        $status = $request->status;

        $inquiries = Inquiry::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                if ($status === 'read') {
                    $query->where('is_read', true);
                } elseif ($status === 'unread') {
                    $query->where('is_read', false);
                }
            })
            ->orderByDesc('id')
            ->paginate(4);

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

        $inquiry->update([
            'is_read' => true
        ]);

        return redirect()->back()->with(
            'success',
            'Inquiry marked as read successfully.'
        );
    }

    public function markAllRead()
    {
        Inquiry::where('is_read', false)->update([
            'is_read' => true
        ]);

        return redirect()->back()->with(
            'success',
            'All inquiries marked as read successfully.'
        );
    }

    public function delete($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        $inquiry->delete();

        return redirect()->back()->with(
            'success',
            'Inquiry deleted successfully.'
        );
    }
}