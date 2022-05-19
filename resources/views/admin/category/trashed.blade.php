@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Category</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Trash</a></li>
    </ol>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-5">
                <div class="card-header">
                    <h3>Trashed Category List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="thead-info">
                            <tr>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Added By</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @forelse ($trashed_categories as $key=>$category )
                            
                        <tbody>
                            <tr>
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
                                    <a href="{{  route('category.restore', $category->id) }}" class="btn btn-success delete shadow btn-xs sharp mr-1"><i class="fa fa-repeat"></i></a>
                                    <a href="{{  route('category.harddelete', $category->id) }}" class="btn btn-danger delete shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No Trashed Data Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection