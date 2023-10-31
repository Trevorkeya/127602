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
    return view('categories.create');
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

}
