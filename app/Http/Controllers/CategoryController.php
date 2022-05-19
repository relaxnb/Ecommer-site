<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $trashed_categories = Category::onlyTrashed()->get();
        return view('admin.category.index', compact('categories', 'trashed_categories'));
    }

    public function insert(CategoryRequest $request)
    {
        //category insert
        $category_id = Category::insertGetId([
            'category_name' => $request->category_name,
            'added_by' => Auth::id(),
            'created_at' => Carbon::now(),
        ]);

        //Category Image Extension
        $category_image = $request->category_image;
        $extension = $category_image->getClientOriginalExtension();
        $file_name = $category_id . '.' . $extension;

        Image::make($category_image)->save(public_path('/uploads/category/' . $file_name));

        Category::withoutTrashed()->find($category_id)->update([
            'category_image' => $file_name,
        ]);

        return back()->with('success', 'Category Add Success!'); //Success Alert
    }

    //Category Soft Delete
    public function soft_delete($category_id)
    {
        Category::find($category_id)->delete();
        return back();
    }

    //Trashed Category
    public function category_restore($category_id)
    {
        Category::onlyTrashed()->find($category_id)->restore();
        return back();
    }

    //Trashed delete Category
    public function category_harddelete($category_id)
    {
        $category_info = Category::onlyTrashed()->find($category_id);
        $image = $category_info->category_image;
        $delete_from = public_path('/uploads/category/' . $image);
        unlink($delete_from);
        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back();
    }

    public function category_trashed()
    {
        $trashed_categories = Category::onlyTrashed()->get();
        return view('admin.category.trashed', compact('trashed_categories'));
    }
    //Edit Category
    public function category_edit($category_id)
    {
        $category_info = Category::withoutTrashed()->find($category_id);
        return view('admin.category.edit', compact('category_info'));
    }

    //Category Update
    public function category_update(Request $request)
    {
        Category::withoutTrashed()->find($request->id)->update([
            'category_name' => $request->category_name,
        ]);
        return redirect(url('/category'));
    }

    public function category_mark_delete(Request $request)
    {
        if ($request->mark == '') {
            return back()->with('empty', 'Please Mark at least one!');
        } else {
            foreach ($request->mark as $mark) {
                Category::find($mark)->delete();
            }
        }

        return back();
    }
}