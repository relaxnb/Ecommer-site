<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Carbon;

class SubcategoryController extends Controller
{
    function index()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.subcategory.index', compact('categories', 'subcategories'));
    }
    function insert(Request $request)
    {

        $request->validate([
            'category_id' => 'required',
            'subcategory_name' => 'required',
        ]);

        if (Subcategory::where('category_id', $request->category_id)->where('subcategory_name', $request->subcategory_name)->exists()) {
            return back()->with('exist', 'Subcategory Already Exist in Selected Category!');
        } else {
            Subcategory::insert([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('success', 'Subcategory Added!');
        }
    }

    function delete($subcategory_id)
    {
        Subcategory::find($subcategory_id)->delete();
        return back()->with('delete', 'Subcategory Deleted Successfully!');
    }

    //Edit SubCategory
    function edit($subcategory_id)
    {
        $categories = Category::all();
        $subcategories = Subcategory::find($subcategory_id);
        return view('admin.subcategory.edit', [
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }

    function update(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_name' => 'required',
        ]);

        if (Subcategory::where('category_id', $request->category_id)->where('subcategory_name', $request->subcategory_name)->exists()) {
            return back()->with('exist', 'Subcategory Already Exist in Selected Category!');
        } else {
            Subcategory::find($request->subcategory_id)->update([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name,
                'created_at' => Carbon::now(),
            ]);
            return redirect(url('/subcategory'))->with('success', 'Subcategory Updated!');
        }
    }
}