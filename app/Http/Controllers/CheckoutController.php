<?php

namespace App\Http\Controllers;

use App\Models\BillingDetails;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\City;
use App\Models\Order;
use App\Models\product;
use App\Models\CartProductDetails;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $total = 0;
        $carts = Cart::where('user_id', Auth::guard('customerlogin')->id())->get();
        $countries = Country::all();

        foreach ($carts as $cart) {
            $total += $cart->rel_to_product->after_discount * $cart->quantity;
        }
        return view('fontend.checkout', [
            'carts' => $carts,
            'total' => $total,
            'countries' => $countries,
        ]);
    }

    //Select City
    public function getCity(Request $request)
    {
        $cities = City::where('country_id', $request->country_id)->get();
        $str_to_send = '<option value="">Select a City&hellip;</option>';
        foreach ($cities as $city) {
            $str_to_send .= '<option value="' . $city->id . '">' . $city->name . '</option>';
        }
        echo $str_to_send;
    }

    //Order
    public function order_insert(Request $request)
    {
        if ($request->payment_method == 1) {
            //Order Insert
            $order_id = Order::insert([
                'user_id' => Auth::guard('customerlogin')->id(),
                'total' => $request->total,
                'discount' => $request->discount,
                'delivery_charge' => $request->delivery_location,
                'payment_method' => $request->payment_method,
                'created_at' => Carbon::now(),
            ]);


            //Biling Details
            BillingDetails::insert([
                'order_id' => $order_id,
                'user_id' => Auth::guard('customerlogin')->id(),
                'name' => $request->name,
                'email' => $request->email,
                'company' => $request->company,
                'phone' => $request->phone,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'address' => $request->address,
                'notes' => $request->notes,
                'created_at' => Carbon::now(),
            ]);


            //Cart Product Details
            $carts = Cart::where('user_id', Auth::guard('customerlogin')->id())->get();
            foreach ($carts as $cart) {
                CartProductDetails::insert([
                    'order_id' => $order_id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->rel_to_product->after_discount,
                    'created_at' => Carbon::now(),
                ]);
            }

            return redirect()->route('order_confirm')->with('order_success', 'Your Order Has been Placed !');
        } else if ($request->payment_method == 2) {
            $total = $request->total;
            $discount = $request->discount;
            $charge = $request->delivery_location;
            return view('exampleHosted', [
                'total' => $total,
                'discount' => $discount,
                'charge' => $charge,
            ]);
        } else {
            return redirect('/');
        }
    }

    //order confirm
    public function order_confirm()
    {
        $carts = Cart::where('user_id', Auth::guard('customerlogin')->id())->get();
        foreach ($carts as $cart) {
            Cart::find($cart->id)->delete();

            product::find($cart->product_id)->decrement('quantity', $cart->quantity);
        }
        return view('fontend.order_confirm');
    }
}