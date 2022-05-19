<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerLogin;

class CustomerLoginController extends Controller
{
    public function customer_login(Request $request)
    {
        // return redirect('/');
        if (Auth::guard('customerlogin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/');
        } else {
            return redirect('/register');
        }
    }

    //Customer Logout
    public function customer_logout(Request $request)
    {
        Auth::guard('customerlogin')->logout();
        return redirect('/');
    }
}