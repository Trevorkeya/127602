<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class MyCoursesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $courses = [];

        if ($user->type === 'user') {
            // For students, retrieve courses they have enrolled in
            $courses = $user->courses;
        } elseif ($user->type === 'admin' || $user->type === 'instructor') {
            // For admins and instructors, retrieve courses they have created
            $courses = Course::where('user_id', $user->id)->get();
        }

        return view('Courses.mycourses.index', compact('courses'));
    }
}
