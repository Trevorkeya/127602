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

    $request->validate([
        'username' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user->name = $request->input('username');
    $user->save();

    $profile = $user->profile ?? $user->profile()->create();
    
    if ($user->type == 'user') {
        $profile->student->phone_number = $request->input('phone');
        $profile->student->save();
    } elseif ($user->type == 'instructor') {
        $profile->instructor->phone_number = $request->input('phone');
        $profile->instructor->save();
    } elseif ($user->type == 'admin') {
        $profile->administrators->phone_number = $request->input('phone');
        $profile->administrators->save();
    }

    if ($request->hasFile('image')) {
        $image = $request->file('image');

        $imageName = time() . '_' . $image->getClientOriginalName();

        $image->storeAs('public/images', $imageName);

        $profile->image = 'images/' . $imageName;
        $profile->save();
    }

    return redirect()->route('profile.show')->with('message', 'Profile updated successfully');
}

}
