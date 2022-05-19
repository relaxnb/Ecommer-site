<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function cart(Request $request)
    {
        $coupon_code = $request->coupon_code;
        $message = null;
        $carts = Cart::where('user_id', Auth::guard('customerlogin')->id())->get();


        if ($coupon_code == '') {
            $discount = 0;
        } else {
            if (Coupon::where('coupon_name', $coupon_code)->exists()) {
                if (Carbon::now()->format('Y-m-d') > Coupon::where('coupon_name', $coupon_code)->first()->validity) {
                    $message = 'Coupon Code Expired';
                    $discount = 0;
                } else {
                    $discount = Coupon::where('coupon_name', $coupon_code)->first()->discount;
                }
            } else {
                $message = 'Coupon Code Invalid';
                $discount = 0;
            }
        }


        return view('fontend.cart', [
            'carts' => $carts,
            'discount' => $discount,
            'coupon_code' => $coupon_code,
            'message' => $message,
        ]);
    }




    public function cart_insert(Request $request)
    {
        if (Cart::where('user_id', Auth::id())->where('product_id', $request->product_id)->exists()) {
            Cart::where('product_id', $request->product_id)->increment('quantity', $request->quantity);
            return back()->with('cart_added', 'product added to cart');
        } else {
            Cart::insert([
                'user_id' => Auth::guard('customerlogin')->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('cart_added', 'product added to cart');
        }
    }

    //Cart Delete
    public function cart_delete($cart_id)
    {
        Cart::find($cart_id)->delete();
        return back();
    }

    //Cart Update
    public function cart_update(Request $request)
    {
        foreach ($request->quantity as $cart_id => $quantity) {
            Cart::find($cart_id)->update([
                'quantity' => $quantity,
            ]);
        }
        return back();
    }
}