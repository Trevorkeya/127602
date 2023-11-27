<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function submitForm(Request $request)
    {
        // Add your validation rules here
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Add logic to handle the form submission (e.g., send an email)

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your message has been submitted successfully!');
    }
}
