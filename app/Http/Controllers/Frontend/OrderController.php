<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        $order_data = Order::where('user_id', $user->id)->get();
        return view('frontend.order', compact('order_data'));
    }
}
