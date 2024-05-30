<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Product;
use App\Models\ContactRequest;
use App\Models\SubCategory;

class FrontendController extends Controller
{
    //
    public function index()
    {
        $sliders = Slider::where('status',0)->get();
        $categories = Category::where('status',0)->get();
        return view('frontend.index', compact('sliders','categories'));
    }

    public function products()
    {
        $categories = Category::where('status',0)->get();
        $products = Product::where('status', 0)->where('quantity', '>', 0)->get();
        return view('frontend.product.index', compact('products', 'categories'));
    }

    public function productShow($slug)
    {
        $product = Product::where('slug',$slug)->firstOrFail();
        $categories = Category::where('status',0)->get();
        $discounted_price = $product->price - ($product->sale_percent * $product->price)/ 100;

        $related_products = Product::where('sub_category_id', $product->sub_category_id)
            ->where('status',0)
            ->where('quantity', '>', 0)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('frontend.product.show', compact('product',
            'discounted_price',
            'related_products', 'categories'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function contactStore(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:8',
            'title' => 'required|string|max:500',
            'description' => 'required'
        ]);

        ContactRequest::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'title' => $validatedData['title'],
            'description' => $validatedData['description']
        ]);

        return redirect('/')->with('success', 'Contact request sent successfully!');
    }
}
