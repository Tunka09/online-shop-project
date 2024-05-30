<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //

    public function index()
    {
        // dd('test');
        $user = Auth::user();
        $cart_data = Cart::where('user_id', $user->id)->get();


        if($cart_data->count() > 0)
        {
            $total_price = $cart_data->sum(function ($item){
                return $item->quantity * $item->product->price * ( 1 - $item->product->sale_percet/100);
            });
            return view('frontend.cart', compact('cart_data', 'total_price'));
        }
        else
        {
            return redirect('/')->with('error', 'Please add items to cart');
        }
    }

    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($id);

        if ($product) {
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            $newQuantity = $validatedData['quantity'];

            if ($cartItem) {
                $newQuantity += $cartItem->quantity;
            }

            if ($newQuantity > $product->quantity) {
                return redirect()->back()->with('error', 'Quantity exceeds available stock.');
            }

            if ($cartItem) {
                $cartItem->update(['quantity' => $newQuantity]);
            }
            else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => $validatedData['quantity']
                ]);
            }

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::findOrFail($request->id);
        $product = $cartItem->product;
        if($request->quantity > $product->quantity)
        {
            return response()->json(['error' => 'Quantity exceeds available stocks'], 400);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $totalPrice = $cartItem->quantity * $product->price * ( 1 - $product->sale_percent/100);
        $totalCartPrice = Cart::where('user_id', Auth::id())->get()->sum(function($item) {
            return $item->quantity * $item->product->price * (1 - $item->product->sale_percent / 100);
        });

        return response()->json([
            'success' => true,
            'totalPrice' => $totalPrice,
            'cartTotal' => $totalCartPrice
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carts,id'
        ]);

        $cartItem = Cart::findOrFail($request->id);
        $cartItem->delete();

        $totalCartPrice = Cart::where('user_id', Auth::id())->get()->sum(function ($item){
           return $item->quantity - $item->product->price * ( 1 - $item->product->sale_percent / 100);
        });

        return response()->json([
            'success' => true,
            'cartTotal' => $totalCartPrice
        ]);
    }

}
