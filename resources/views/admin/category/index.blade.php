@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Category</a></li>
    </ol>
</div>
<div class="container_fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/category/insert')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-3">
                            <label for="form-label">Category Name</label>
                            <input type="text" name="category_name" class="form-control">
                            @error('category_name')
                                <strong class="text-danger mt-2">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="form-label">Category image</label>
                            <input type="file" name="category_image">
                            @error('category_image')
                                <strong class="text-danger mt-2">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Add Categoty</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Category List</h3>
                </div>
                <div class="card-body">
                    @if (session('empty'))
                        <div class="alert alert-danger"></div>
                    @endif
                    <form action="{{ url('/category/mark/delete')}}" method="POST">
                        @csrf
                        <table class="table table-hover">
                            <thead class="thead-primary">
                                <tr>
                                    <th><input type="checkbox" id="checkAll"> Mark All</th>
                                    <th>SL</th>
                                    <th>Category Name</th>
                                    <th>Added By</th>
                                    <th>Image</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @forelse ($categories as $key=>$category )
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" name="mark[]" value="{{ $category->id }}"></td>
                                    <td>{{$key+1}}</td>
                                    <td>{{$category->category_name}}</td>
                                    <td>
                                        @php
                                            if(App\Models\User::where('id', $category->added_by)->exists()){
                                                echo $category->rel_to_user->name;
                                            }else{
                                                echo 'N/A';
                                            }
                                        @endphp
                                    </td>
                                    <td>
                                        <img src="{{asset('/uploads/category')}}/{{$category->category_image}}" alt="" width="50">
                                    </td>
                                    <td>{{$category->created_at->diffForHumans()}}</td>
                                    <td>
                                        <a href="{{  route('category.edit', $category->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                        <a href="{{  route('category.softdelete', $category->id) }}" class="btn btn-danger delete shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Category Data Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-danger">Delete All</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 


@section('footer_script')
{{-- Sweet alert --}}
@if (session('success'))
    <script>
        Swal.fire(
        'Success!',
        '{{ session('success')}}',
        'success'
    )
    </script>
@endif

<script>
    $("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});
</script>
@endsection