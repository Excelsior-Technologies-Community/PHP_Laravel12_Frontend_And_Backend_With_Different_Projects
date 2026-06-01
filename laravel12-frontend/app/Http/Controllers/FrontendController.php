<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function storeInquiry(Request $request)
    {
        $request->validate([
            'name'    => 'required|max:100',
            'email'   => 'required|email',
            'phone'   => 'nullable|max:20',
            'message' => 'required|max:1000',
        ]);

        Inquiry::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'message' => $request->message,
        ]);

        return redirect('/')
            ->with('success', 'Inquiry submitted successfully.');
    }
}