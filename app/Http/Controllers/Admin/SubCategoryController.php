<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategoryController extends Controller
{
    //
    public function index()
    {
        $subcategories = SubCategory::all();
        return view('admin.subcategory.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100|unique:sub_categories'
        ]);

        SubCategory::create([
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'slug' => $validatedData['name']
        ]);

        return redirect('admin/subcategory')->with('message', 'SubCategory Created Successfully');
    }

    public function edit($id)
    {
        // dd($id);
        $categories = Category::all();
        $subcategory = SubCategory::findOrFail($id);
        return view('admin.subcategory.edit', compact('categories' , 'subcategory'));
        // return view('admin.subcategory.edit', compact('subcategory'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category' => 'required|exists:categories,id',
            'name' => 'required|string|max:200|unique:sub_categories,name,' . $id,
            'slug' => 'required|string|max:200|unique:sub_categories,slug,' . $id
        ]);

        $subcategory = SubCategory::findOrFail($id);
        $subcategory->update([
            'category_id' => $validatedData['category'],
            'name' => $validatedData['name'],
            'slug' => $validatedData['name'],
        ]);

        return redirect('admin/subcategory')->with('message', 'SubCategory Updated Successfully');
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::find($id);
        $subcategory->delete();
        return redirect('admin/subcategory')->with('status','Subcategory Deleted Successfully');
    }
}
