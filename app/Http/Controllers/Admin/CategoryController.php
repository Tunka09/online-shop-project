<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request){
        // dd($request->all());

        $validateData = $request->validate([
            "name" => "required|max:50|unique:categories",
            "slug" => "required|max:50|unique:categories",
            "status" => "nullable",
            "image" => "required|image|mimes:jpg,png,svg"
        ]);

        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/category/', $filename);
            $validateData['image'] = 'uploads/category/'. $filename;
        }

        $validateData['status'] = $request->status == true ? '1':'0';

        Category::create([
            'name' => $validateData['name'],
            'slug' => $validateData['slug'],
            'status' => $validateData['status'],
            'image' => $validateData['image']
        ]);

        return redirect('admin/category')->with('message', 'Category Created Successfully');
    }

    public function edit($id)
    {
        $category = Category::find($id);
//        dd($category);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $validatedData = $request->validate([
            "name" => "required|max:50|unique:categories,name," . $category->id,
            "slug" => "required|max:50|unique:categories,slug," . $category->id,
            "status" => "nullable",
            "image" => "nullable|image|mimes:jpg,png,svg",
        ]);

        if ($request->hasFile('image'))
        {
//            use Illuminate\Support\Facades\File;
            if (File::exists($category->image)){
                File::delete($category->image);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext; //147785.png
            $file->move('uploads/category/', $filename);
            $validatedData['image'] = 'uploads/category/'. $filename;
        }

        $validatedData['status'] = $request->status == true ? '1':'0';

        $category->update($validatedData);

        return redirect('admin/category')->with('message','Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect('admin/category')->with('status','Category Deleted Successfully');
    }
}
