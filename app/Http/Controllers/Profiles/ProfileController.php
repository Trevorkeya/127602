<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function show()
    {
        $user = auth()->user();
        return view('Profiles.index', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('Profiles.edit', compact('user'));
    }

    public function update(Request $request)
{
    $user = auth()->user();

    // Validate the request data
    $request->validate([
        'username' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Update user details
    $user->name = $request->input('username');
    $user->save();

    // Update profile details
    $profile = $user->profile ?? $user->profile()->create();
    
    // Handle phone number based on user type
    if ($user->type == 'user') {
        // Update student's phone number
        $profile->student->phone_number = $request->input('phone');
        $profile->student->save();
    } elseif ($user->type == 'instructor') {
        // Update instructor's phone number
        $profile->instructor->phone_number = $request->input('phone');
        $profile->instructor->save();
    } elseif ($user->type == 'admin') {
        // Update administrator's phone number
        $profile->administrators->phone_number = $request->input('phone');
        $profile->administrators->save();
    }

    // Handle image upload if provided
    if ($request->hasFile('image')) {
        // Get the uploaded file
        $image = $request->file('image');

        // Generate a unique name for the image
        $imageName = time() . '_' . $image->getClientOriginalName();

        // Store the image in the 'public' disk (you can customize the disk based on your configuration)
        $image->storeAs('public/images', $imageName);

        // Update the profile with the image path
        $profile->image = 'images/' . $imageName;
        $profile->save();
    }

    return redirect()->route('profile.show')->with('message', 'Profile updated successfully');
}

}
