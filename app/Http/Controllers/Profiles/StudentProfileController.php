<?php

namespace App\Http\Controllers\Profiles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Profile;

class StudentProfileController extends Controller
{
    public function index()
    {
        $students = Student::all(); 
        return view('Profiles.Students.index', compact('students'));
    }

    public function edit($id)
    {
        $student = Student::find($id);
        $profile = $student->profile ?? new Profile();
        return view('Profiles.Students.edit', compact('student', 'profile'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date_of_birth' => 'required|date',
            'phone_number' => 'required',
        ]);

        $student = Student::find($id);

        $profile = $student->profile ?? new StudentProfile();
        $profile->date_of_birth = $request->date_of_birth;
        $profile->phone_number = $request->phone_number;
        $profile->save();

        return redirect()->route('student_profile.index')
            ->with('success', 'Profile updated successfully');
    }

    public function uploadImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $studentProfile = StudentProfile::updateOrCreate(
            ['student_id' => $id],
            ['image' => $imageName]
        );

        return back()->with('success', 'Image uploaded successfully.');
    }
}
