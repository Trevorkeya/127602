<?php

namespace App\Http\Controllers\Admin;

use App\Models\Material;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        
        $materials = Material::all(); // Fetch all materials
        $categoryId = $request->input('category');

        $materials = Material::when($categoryId, function ($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        })->get();

        $categories = Category::all();

        return view('Materials.Index', [
            'materials' => $materials,
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('Materials.Create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,ppt,pptx,mp4', 
            'category' => 'required',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName(); // Get the original file name
        $filePath = $file->store('materials'); // Store the file in the materials directory
        $fileExtension = $file->getClientOriginalExtension();
        


        Material::create([
            'title' => $request->title,
            'file_path' => $filePath,
            'type' => $file->getClientOriginalExtension(), // Get file extension
            'user_id' => auth()->id(), // Assign the currently logged-in user's ID
            'category_id' => $request->category,
        ]);

        return redirect()->route('materials.index')->with('success', 'Material uploaded successfully');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material deleted successfully');
    }

    public function download($file)
   {
    $path = storage_path('app/materials/' . $file); 

    if (file_exists($path)) {
        return response()->download($path);
    } else {
        
        return response()->json(['error' => 'File not found.'], 404);
    }
   }

}
