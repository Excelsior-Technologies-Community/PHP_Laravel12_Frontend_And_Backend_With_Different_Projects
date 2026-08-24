<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function dashboard(Request $request)
    {
        $inquiries = Inquiry::where('user_id', Auth::id())
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('subject', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%")
                        ->orWhere('reference_number', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderByDesc('id')
            ->paginate(10);

        $stats = [
            'total' => Inquiry::where('user_id', Auth::id())->count(),
            'pending' => Inquiry::where('user_id', Auth::id())->where('status', 'pending')->count(),
            'in_progress' => Inquiry::where('user_id', Auth::id())->where('status', 'in_progress')->count(),
            'resolved' => Inquiry::where('user_id', Auth::id())->where('status', 'resolved')->count(),
        ];

        return view('frontend.customer.dashboard', compact('inquiries', 'stats'));
    }
}
