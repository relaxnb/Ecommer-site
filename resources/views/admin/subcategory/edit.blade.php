@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Sub Category</a></li>
    </ol>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Update Subcategory</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/subcategory/update') }}" method="POST">
                        @csrf
                        <div class="mt-3">
                            <input type="hidden" name="subcategory_id" value="{{ $subcategories->id }}">
                            <select name="category_id" class="form-control">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option {{($category->id == $subcategories->category_id?'selected':'')}} value="{{$category->id}}" >{{$category->category_name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Subcategory Name</label>
                            <input type="text" class="form-control" value="{{ $subcategories->subcategory_name}}" name="subcategory_name">
                            @error('subcategory_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Update Subcategory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
