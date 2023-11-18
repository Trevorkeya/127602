<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class EnrollmentController extends Controller
{
    public function enroll(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        if ($course->enrollment_key === $request->enrollment_key) {
            $course->users()->attach(auth()->user()->id);
            return redirect()->route('courses.show', $courseId)->with('success', 'Enrolled successfully');
        }

        return back()->with('error', 'Invalid enrollment key');
    }

}
