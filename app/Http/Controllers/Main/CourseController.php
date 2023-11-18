<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\User;


class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('users')->get();
        return view('Courses.index', compact('courses'));
    }

    public function create()
    {
        return view('Courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required',
            'description' => 'required',
            'title' => 'required',
            'enrollment_key' => 'required',
        ]);

        Course::create([
            'course_code' => $request->course_code,
            'description' => $request->description,
            'title' => $request->title,
            'enrollment_key' => $request->enrollment_key,
            'user_id' => auth()->id(), 
        ]);

        return redirect()->route('courses.index')->with('success', 'Course created successfully');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('Courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'course_code' => 'required',
            'description' => 'required',
            'title' => 'required',
        ]);

        Course::findOrFail($id)->update($request->all());

        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        $course = Course::with('topics.materials')->find($id);
        $quizzes = Quiz::all();
        return view('Courses.show', compact('course','quizzes'));
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully');
    }

    public function dashboard(){

        $courses = Course::all();
    
        return view('Admin.Courses.Index', ['courses' => $courses]);
       }

}
