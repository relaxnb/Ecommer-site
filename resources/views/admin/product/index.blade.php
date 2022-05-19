@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Add Product</a></li>
    </ol>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-feature-left card-feature-primary">
                <div class="card-header bg-primary">
                    <h3 class="text-white">Add Product</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/product/insert')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <select name="category_id" class="form-control" id="category_id">
                                        <option value="">--Select Category--</option>
                                        @foreach ($all_categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <select name="subcategory_id" class="form-control" id="subcategory_id">
                                        <option value="">--Select Sub Category--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="form-label">Product Name</label>
                                    <input type="text" name="product_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="form-label">Product price</label>
                                    <input type="number" name="product_price" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="form-label">Product Discount</label>
                                    <input type="number" name="product_discount" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="form-label">Quantity</label>
                                    <input type="number" name="quantity" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="form-label">Short Description</label>
                                    <input type="text" name="short_discp" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="form-label">Long Description</label>
                                    <textarea name="long_discp" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="form-label">Product preview</label>
                                    <input type="file" name="preview" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="form-label">Product Thumbnails</label>
                                    <input type="file" multiple name="thumbnail[]" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Add Product</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('footer_script')
    {{-- No reload Use to Ajax --}}
    <script>
        $('#category_id').change(function(){
            var category_id = $('#category_id').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //Ajax Formate
            $.ajax({
                type:'POST',
                url:'/getcategory',
                data:{'category_id':category_id},
                success:function(data){
                    $('#subcategory_id').html(data);
                }
            });

        });
    </script>
@endsection