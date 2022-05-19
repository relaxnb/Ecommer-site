@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Edit</a></li>
    </ol>
</div>
<div class="container">
    <div class="row">
        <div class="col-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/category/update')}}" method="POST">
                        @csrf
                        <div class="mt-3">
                            <label for="" class="form-label">Category Name</label>
                            <input type="hidden" name="id" value="{{$category_info->id}}" class="form-control">
                            <input type="text" name="category_name" value="{{$category_info->category_name}}" class="form-control">
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection