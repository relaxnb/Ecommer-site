<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductThumbnail;
use App\Models\Subcategory;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function index()
    {
        $all_categories = Category::all();
        $all_subcategories = Subcategory::all();
        return view('admin.product.index', [
            'all_categories' => $all_categories,
            'all_subcategories' => $all_subcategories,
        ]);
    }

    //Insert Product
    public function insert(Request $request)
    {
        $product_id = Product::insertGetId([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_discount' => $request->product_discount,
            'after_discount' => $request->product_price - $request->product_price * $request->product_discount / 100,
            'quantity' => $request->quantity,
            'short_discp' => $request->short_discp,
            'long_discp' => $request->long_discp,
        ]);

        //Image Extension/Update
        $product_preview = $request->preview;
        $preview_extension = $product_preview->getClientOriginalExtension(); //Extension name
        $preview_image_name = $product_id . '.' . $preview_extension;
        Image::make($product_preview)->resize(680, 600)->save(public_path('/uploads/products/preview/' . $preview_image_name));
        Product::find($product_id)->update([
            'preview' => $preview_image_name,
        ]);

        //Thumbnail Extension/Product Uploa
        $loop = 1;
        foreach ($request->thumbnail as $thumbnail) {
            $extension = $thumbnail->getClientOriginalExtension();
            $thumbnail_name = $product_id . '-' . $loop . '.' . $extension;
            Image::make($thumbnail)->resize(680, 600)->save(public_path('/uploads/products/thumbnails/' . $thumbnail_name));

            ProductThumbnail::insert([
                'product_id' => $product_id,
                'thumbnail' => $thumbnail_name,
            ]);
            $loop++;
        };
        return back();
    }

    //Subcategory Relation
    public function getcategory(Request $request)
    {
        $str_to_send = '<option value="">--Select Sub Category--</option>';
        foreach (Subcategory::where('category_id', $request->category_id)->get() as $subcategory) {
            $str_to_send .= '<option value="' . $subcategory->id . '">' . $subcategory->subcategory_name . '</option>';
        }
        echo $str_to_send;
    }

    //View Product
    public function view_product()
    {
        $all_products = Product::all();
        return view('admin.product.view', [
            'all_products' => $all_products,
        ]);
    }

    //Delete Product
    public function product_delete($product_id)
    {
        //Preview image delete
        $product_image = Product::where('id', $product_id)->first()->preview;
        $delete_from = public_path('/uploads/products/preview/' . $product_image);
        unlink($delete_from);

        //Thumbnail product delete
        $product_thumbnail = ProductThumbnail::where('product_id', $product_id)->get();
        foreach ($product_thumbnail as $thumbnail) {
            $delete_from = public_path('/uploads/products/thumbnails/' . $thumbnail->thumbnail);
            unlink($delete_from);
        }

        Product::find($product_id)->delete();

        return back();
    }
}