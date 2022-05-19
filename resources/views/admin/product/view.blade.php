@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Product List</a></li>
    </ol>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Product list</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>SL</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>After Discount</th>
                                <th>Quantity</th>
                                <th>Short Descp</th>
                                <th>Long Descp</th>
                                <th>Preview</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($all_products as $key=>$product) 
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$product->rel_to_category->category_name}}</td>
                                    <td>{{$product->rel_to_subcategory->subcategory_name}}</td>
                                    <td>{{$product->product_name}}</td>
                                    <td>{{$product->product_price}}</td>
                                    <td>{{ ($product->product_discount == ''?'-':$product->product_discount)}}</td>
                                    <td>{{$product->after_discount}}</td>
                                    <td>{{$product->quantity}}</td>
                                    <td>{{ substr($product->short_discp, 0,10).'...'}}</td>
                                    <td>{{ substr($product->long_discp, 0,10).'...'}}</td>
                                    <td>
                                        <img width="50" src="{{ asset('/uploads/products/preview') }}/{{$product->preview}}" alt="">
                                    </td>
                                    <td>
                                        <a href="{{ route('product.delete', $product->id)}}" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection