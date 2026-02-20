<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10|max:2000',
        ]);

        // In a real app you'd Mail::to(...)->send(...)
        // For demo we just return success after a short pause
        sleep(0); // no real delay needed — AJAX loader handles it

        return response()->json([
            'success' => true,
            'message' => 'Thank you, ' . $validated['name'] . '! Your message has been received. We\'ll get back to you shortly.',
        ]);
    }
}
