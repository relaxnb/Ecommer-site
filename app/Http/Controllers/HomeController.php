<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home',);
    }

    //User Delete
    public function user_delete($user_id)
    {
        User::find($user_id)->delete();
        return back()->with('delete', 'User Delete Success!'); // Delete alert
    }

    public function users()
    {
        $logged_user_id = Auth::id();
        $all_users = User::where('id', '!=', $logged_user_id)->get(); //User Self hidden
        $logged_user = Auth::user()->name;
        $total_users = User::count();
        return view('admin.user.index', compact('all_users', 'logged_user', 'total_users'));
    }
}