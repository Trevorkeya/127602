<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
  {
    $category= category::all();
    return view ('Categories.Index',compact('category'));
  }
    public function create()
  {
    return view('Categories.Create');
  }

  public function store(Request $request)
 {
    $request->validate([
        'name' => 'required|unique:categories,name',

    ]);

    $category = new category();
    $category->name = $request->name;

    $category->save();
    return redirect('/categories/index')->with('success', 'Category created successfully!');
 }
 
 public function edit($id)
 {
     $category = Category::findOrFail($id);
     return view('Categories.Edit', compact('category'));
 }

 public function update(Request $request, $id)
 {
     $request->validate([
         'name' => 'required|unique:categories,name,' . $id,
     ]);

     $category = Category::findOrFail($id);
     $category->name = $request->name;
     $category->save();

     return redirect('/categories/index')->with('success', 'Category updated successfully!');
 }

 public function destroy($id){
    $category = Category::findOrFail($id);
    $category->delete();

    return redirect('/categories/index')->with('success', 'Category deleted successfully!');
  }

}
