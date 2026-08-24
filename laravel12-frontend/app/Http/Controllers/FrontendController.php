<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\InquiryConfirmation;

class FrontendController extends Controller
{
    public function storeInquiry(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|max:20',
            'subject' => 'nullable|max:255',
            'message' => 'required|max:1000',
            'category_id' => 'nullable|exists:categories,id',
            'attachment' => 'nullable|file|max:2048',
            'g-recaptcha-response' => 'nullable',
        ]);

        $reference = 'INQ-' . strtoupper(Str::random(8));
        $tracking = Str::random(32);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'category_id' => $request->category_id,
            'reference_number' => $reference,
            'tracking_token' => $tracking,
            'status' => 'pending',
            'priority' => 'medium',
        ];

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('inquiries', 'public');
        }

        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        }

        Inquiry::create($data);

        try {
            Mail::to($request->email)->send(new InquiryConfirmation($reference, $tracking));
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Inquiry submitted successfully!',
                'reference' => $reference,
                'redirect' => route('inquiry.thankyou', $reference),
            ]);
        }

        return redirect()->route('inquiry.thankyou', $reference)
            ->with('success', 'Inquiry submitted successfully.');
    }

    public function trackForm()
    {
        return view('frontend.track');
    }

    public function track(Request $request)
    {
        $request->validate([
            'reference' => 'required|string',
            'email' => 'required|email',
        ]);

        $inquiry = Inquiry::where('reference_number', $request->reference)
            ->where('email', $request->email)
            ->first();

        if (!$inquiry) {
            return back()->withErrors(['reference' => 'No inquiry found with this reference number and email.']);
        }

        return view('frontend.track-result', compact('inquiry'));
    }

    public function thankYou($reference)
    {
        $inquiry = Inquiry::where('reference_number', $reference)->firstOrFail();
        return view('frontend.thankyou', compact('inquiry'));
    }
}
