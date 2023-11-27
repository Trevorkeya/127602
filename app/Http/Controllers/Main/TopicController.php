<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Material;
use App\Models\Course;
use App\Models\Category;

class TopicController extends Controller
{
    public function index($courseId)
    {
        $course = Course::find($courseId);
        $topics = Topic::where('course_id', $courseId)->get();
        $materials = Material::all();
        return view('Courses.Show', compact('course', 'topics', 'materials'));
    }

    public function create($courseId)
    {
        $course = Course::find($courseId);
        $materials = Material::all();
        return view('Topics.Create', compact('course','materials'));
    }

    public function store(Request $request, $courseId)
    {
        $topic = new Topic();
        $topic->title = $request->title;
        $topic->course_id = $courseId;
        $topic->save();

        $topic->materials()->sync($request->materials);

        return redirect()->route('courses.show', $courseId)->with('success', 'Topic created successfully');
    }

    public function edit($courseId, $topicId)
    {
        $course = Course::find($courseId);
        $topic = Topic::find($topicId);
        $materials = Material::all();
        return view('Topics.Edit', compact('course', 'topic', 'materials'));
    }

    public function update(Request $request, $courseId, $topicId)
    {
        $topic = Topic::find($topicId);
        $topic->title = $request->title;
        $topic->save();

        $topic->materials()->sync($request->materials);

        return redirect()->route('courses.show', $courseId)->with('success', 'Topic updated successfully');
    }

    public function destroy($courseId, $topicId)
    {
        $topic = Topic::find($topicId);
        $topic->materials()->detach(); 
        $topic->delete();

        return redirect()->route('courses.show', $courseId)->with('success', 'Topic deleted successfully');
    }

    public function createMaterials($courseId, $topicId) {
        $course = Course::find($courseId);
        $topic = Topic::find($topicId);
        $materials = Material::all();
        $categories = Category::all();
        return view('Topics.materials', compact('course', 'topic', 'materials', 'categories'));
    }
    
    public function storeMaterials(Request $request, $courseId, $topicId) {
        $selectedMaterials = $request->input('existing_materials');
        $topic = Topic::find($topicId);
    
        if ($selectedMaterials !== null && is_array($selectedMaterials)) {

            $topic->materials()->syncWithoutDetaching($selectedMaterials);

        }
    
        
        if ($request->hasFile('file')) {
          
            $request->validate([
                'title' => 'required',
                'file' => 'required|mimes:pdf,doc,docx,ppt,pptx,mp4',
                'category' => 'required',
            ]);
    
            $file = $request->file('file');
            $filePath = $file->store('materials'); 
    
            $material = new Material();
            $material->title = $request->title;
            $material->file_path = $filePath;
            $material->type = $file->getClientOriginalExtension();
            $material->user_id = auth()->id();
            $material->category_id = $request->category;
            $material->save();
    
            $topic->materials()->attach($material->id);
        }
    
        return redirect()->route('courses.show', $courseId)->with('success', 'Materials added successfully');
    }
    
    public function viewPDF($materialId)
    {
        $material = Material::findOrFail($materialId);

        if ($material->type !== 'pdf') {
            abort(404); 
        }

        $pdfPath = Storage::path($material->file_path);

        if (!file_exists($pdfPath)) {
            abort(404);
        }

        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $material->title . '.pdf"',
        ]);
    }

    
    
    
}
