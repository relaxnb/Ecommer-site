@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Sub Category</a></li>
    </ol>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Subcategory</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/subcategory/insert') }}" method="POST">
                        @csrf
                        <div class="mt-3">
                            <select name="category_id" class="form-control">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Subcategory Name</label>
                            <input type="text" class="form-control" name="subcategory_name">
                            @error('subcategory_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Add Subcategory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Subcategory List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subcategories as $key=>$subcategory)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    @php
                                        
                                        if(App\Models\Category::where('id', $subcategory->category_id)->exists()){
                                            echo $subcategory->rel_to_category->category_name;
                                        }else{
                                            echo 'N/A';
                                        }
                                    @endphp
                                </td>
                                <td>{{ $subcategory->subcategory_name }}</td>
                                <td>{{ $subcategory->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('subcategory.edit', $subcategory->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                    <a href="{{ route('subcategory.delete', $subcategory->id) }}" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
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

@section('footer_script')
@if (session('success'))
    <script>
        Swal.fire(
            'Success!',
            '{{ session('success') }}',
            'success'
        )
    </script>
@endif
@if (session('exist'))
    <script>
        Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session('exist') }}',
        })
    </script>
@endif
@if (session('delete'))
    <script>
        Swal.fire({
        icon: 'success',
        text: '{{ session('delete') }}',
        })
    </script>
@endif
@endsection
