<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Administrators;
use App\Models\Instructor;
use App\Models\Student;

use PDF;
class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::with('users')->where('status', true)->get();

        $search = $request->input('search');
    
        $courses = Course::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                         ->orWhere('course_code', 'like', '%' . $search . '%');
        })->get();

        return view('Courses.Index', compact('courses'));
    }

    public function create(){

        return view('Courses.Create');

    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required',
            'description' => 'required',
            'title' => 'required',
            'enrollment_key' => 'required',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $courseData = $request->except('background_image');

        if ($request->hasFile('background_image')) {
            $imagePath = $request->file('background_image')->store('images', 'public');
            $courseData['background_image'] = $imagePath;
        }

        $courseData['user_id'] = auth()->id();

        Course::create($courseData);

        return redirect()->route('courses.index')->with('success', 'Course created successfully');
    }


    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('Courses.Edit', compact('course'));
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_code' => 'required',
            'description' => 'required',
            'title' => 'required',
            'enrollment_key' => 'required',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        $course = Course::findOrFail($id);
        $courseData = $request->except('background_image');

        if ($request->hasFile('background_image')) {
            // Delete the old background image if it exists
            Storage::disk('public')->delete($course->background_image);

            // Upload the new background image
            $imagePath = $request->file('background_image')->store('image', 'public');
            $courseData['background_image'] = $imagePath;
        }

        $course->update($courseData);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully');
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        $course = Course::with('topics.materials')->find($id);
        $quizzes = Quiz::all();
        return view('Courses.Show', compact('course','quizzes'));
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

    public function toggleStatus($id)
    {
        $course = Course::findOrFail($id);
        $course->update(['status' => !$course->status]);
       
        return back()->with('success', 'Course status updated successfully');
    }

    public function showTopics(Course $course)
    {
        $topics = $course->topics;

        return view('Admin.Courses.showTopics', compact('course', 'topics'));
    }

    public function enrolledUsers(Course $course)
   {
    $enrolledUsers = $course->users;

    return view('Admin.Courses.EnrolledUsers', compact('course', 'enrolledUsers'));
   }

   public function generatePDF()
  {
    $courses = Course::all();

    $pdf = PDF::loadView('Admin.Courses.PDF', compact('courses'));

    return $pdf->download('Courses.pdf');
  }

  public function viewPDF()
{
    $courses = Course::all(); 

    $pdf = PDF::loadView('pdf.coursesdetails', ['courses' => $courses])
        ->setPaper('a4', 'portrait');

    return $pdf->stream();
}

public function downloadPDF()
{
    $courses = Course::all();
    $pdf = PDF::loadView('pdf.coursesdetails', ['courses' => $courses])
        ->setPaper('a4', 'portrait');

    return $pdf->download('courses-details.pdf');
}

public function dashboards()
{
    $studentsCount = User::where('type', 0)->count();
    $adminsCount = User::where('type', 1)->count();
    $instructorsCount = User::where('type', 2)->count();

    $courses = Course::withCount('users')->get();
    $coursesCount = $courses->count();

    return view('Admin.Dashboard', [
        'coursesCount' => $coursesCount,
        'studentsCount' => $studentsCount,
        'adminsCount' => $adminsCount,
        'instructorsCount' => $instructorsCount,
        'courses' => $courses,
    ]);
}
}
