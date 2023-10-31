<?php

namespace App\Http\Controllers\Admin;

use App\Models\Material;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all(); // Fetch all materials
        return view('Materials.Index', ['materials' => $materials]);
    }

    public function create()
    {
        return view('Materials.Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file' => 'required|mimes:pdf,doc,docx,ppt,pptx,mp4', // Specify allowed file types
            // 'category' => 'required',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName(); // Get the original file name
        $filePath = $file->store('materials'); // Store the file in the materials directory
        $fileExtension = $file->getClientOriginalExtension();


        Material::create([
            'title' => $request->title,
            'file_path' => $filePath,
            'type' => $file->getClientOriginalExtension(), // Get file extension
            // 'user_id' => auth()->id(), // Assign the currently logged-in user's ID
            // 'category_id' => $request->category,
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
    $path = storage_path('app/materials/' . $file); // Assuming your files are stored in the storage directory

    if (file_exists($path)) {
        return response()->download($path);
    } else {
        // Handle file not found scenario
        return response()->json(['error' => 'File not found.'], 404);
    }
   }

}
