<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function coupon()
    {
        $coupons = Coupon::all();
        return view('admin.coupon.index', [
            'coupons' => $coupons,
        ]);
    }

    //Coupon Insert
    public function coupon_insert(Request $request)
    {
        Coupon::insert([
            'coupon_name' => $request->coupon_name,
            'discount' => $request->discount,
            'validity' => $request->validity,
            'created_at' => Carbon::now(),
        ]);
        return back();
    }
}