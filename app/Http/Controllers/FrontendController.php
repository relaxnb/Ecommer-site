<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CustomerLogin;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        $all_categories = Category::all();
        $all_product = Product::take(6)->get();
        return view('fontend.index', [
            'all_categories' => $all_categories,
            'all_product' => $all_product,
        ]);
    }

    public function product_details($product_id)
    {
        $product_info = Product::find($product_id);
        $related_products = Product::where('category_id', $product_info->category_id)->where('id', '!=', $product_id)->get();
        return view('fontend.product_details', [
            'product_info' => $product_info,
            'related_products' => $related_products,
        ]);
    }

    public function profile()
    {
        $orders = Order::where('user_id', Auth::guard('customerlogin')->id())->get();
        return view('fontend.profile', [
            'orders' => $orders,
        ]);
    }

    // Update profile user
    public function profile_update(Request $request)
    {
        CustomerLogin::find(Auth::guard('customerlogin')->id())->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);
        return back();
    }
}