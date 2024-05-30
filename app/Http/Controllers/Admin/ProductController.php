<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\Brand;


class ProductController extends Controller
{
    //
    public function index()
    {
        $products = Product::orderBy('created_at' , 'DESC')->get();
        // dd($products->all());
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $subcategories = SubCategory::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('subcategories' , 'brands'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'subcategory' => 'required|exists:sub_categories,id',
            'brand' => 'required|exists:brands,id',
            'name' => 'required|string|max:200|unique:products',
            'slug' => 'required|string|max:200|unique:products',
            'price' => 'required|integer|min:0',
            'sale_percent' => 'required|integer|min:0|max:100',
            'quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,png',
            'trending' => 'nullable',
            'status' => 'nullable',
            'picture.*' => 'nullable|image'
        ]);

        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/product/',$filename);
            $validatedData['image'] = 'uploads/product/'.$filename;
        }

        $validatedData['trending'] = $request->trending == true ? '1':'0';
        $validatedData['status'] = $request->status == true ? '1':'0';

        // dd($validatedData);
        $product = Product::create([
            'sub_category_id' => $validatedData['subcategory'],
            'brand_id' => $validatedData['brand'],
            'name' => $validatedData['name'],
            'slug' => $validatedData['slug'],
            'sale_percent' => $validatedData['sale_percent'],
            'price' => $validatedData['price'],
            'quantity' => $validatedData['quantity'],
            'description' => $validatedData['description'],
            'image' => $validatedData['image'],
            'trending' => $validatedData['trending'],
            'status' => $validatedData['status'],
        ]);

        if($request->hasFile('picture')){
            $uploadPath = 'uploads/product/picture/';
            $i = 1;
            foreach($request->file('picture') as $imageFile){
                $extension = $imageFile->getClientOriginalExtension();
                $filename = time().$i++.'.'.$extension;
                $imageFile->move($uploadPath, $filename);
                $finalImagePathName = $uploadPath.$filename;
                
                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalImagePathName
                ]);
            }
        }

        return redirect('admin/product')->with('message', 'Product Added Successfully');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $subcategories = SubCategory::all();
        $brands = Brand::all();
        return view('admin.product.edit', compact('product', 'subcategories' , 'brands'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'subcategory' => 'required|exists:sub_categories,id',
            'brand' => 'required|exists:brands,id',
            'name' => 'required|string|max:200|unique:products,name,' . $id,
            'slug' => 'required|string|max:200|unique:products,slug,' . $id,
            'price' => 'required|integer|min:0',
            'sale_percent' => 'required|integer|min:0|max:100',
            'quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'sometimes|image|mimes:jpg,png',
            'trending' => 'nullable',
            'status' => 'nullable'
        ]);

        if($request->hasFile('image')){

            if(File::exists($product->image)) {
                File::delete($product->image);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/product/', $filename);
            $validatedData['image'] = 'uploads/product/' . $filename;
        }

        $validatedData['trending'] = $request->trending == true ? '1':'0';
        $validatedData['status'] = $request->status == true ? '1':'0';
        
        if($request->hasFile('image')){
            $product->update([
                'sub_category_id' => $validatedData['subcategory'],
                'brand_id' => $validatedData['brand'],
                'name' => $validatedData['name'],
                'slug' => $validatedData['slug'],
                'sale_percent' => $validatedData['sale_percent'],
                'price' => $validatedData['price'],
                'quantity' => $validatedData['quantity'],
                'description' => $validatedData['description'],
                'image' => $validatedData['image'],
                'trending' => $validatedData['trending'],
                'status' => $validatedData['status'],
            ]);
        }
        else{
            $product->update([
                'sub_category_id' => $validatedData['subcategory'],
                'brand_id' => $validatedData['brand'],
                'name' => $validatedData['name'],
                'slug' => $validatedData['slug'],
                'sale_percent' => $validatedData['sale_percent'],
                'price' => $validatedData['price'],
                'quantity' => $validatedData['quantity'],
                'description' => $validatedData['description'],
                'trending' => $validatedData['trending'],
                'status' => $validatedData['status'],
            ]);
        }
        

        return redirect('admin/product')->with('message', 'Product Updated Successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if($product){
            $destination = $product->image;
            if(File::exists($destination))
            {
                File::delete($destination);
            }

            $product->delete();
            return redirect('admin/product')->with('message', 'Product Deleted Successfully!');
        }
        return redirect('admin/product')->with('message', 'Something went wrong!');
    }

    public function showImage($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.image', compact('product'));
    }

    public function storeImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if($request->hasFile('image')){
            $uploadPath = 'uploads/product/picture/';
            $i = 1;
            foreach($request->file('image') as $imageFile){
                $extension = $imageFile->getClientOriginalExtension();
                $filename = time().$i++.'.'.$extension;
                $imageFile->move($uploadPath, $filename);
                $finalImagePathName = $uploadPath.$filename;
                
                $product->productImages()->create([
                    'product_id' => $product->id,
                    'image' => $finalImagePathName
                ]);
            }
        }

        return redirect()->back()->with('message', 'Image Uploaded Successfully');
    }

    public function removeImage($id)
    {
        $productImage = ProductImage::findOrFail($id);
        
        if(File::exists($productImage->file)){
            File::delete($productImage->file);
        }
        $productImage->delete();
        return redirect()->back()->with('message', 'Image Deleted Successfully');
    }
}
