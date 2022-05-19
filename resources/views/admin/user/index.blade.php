@extends('layouts.dashboard')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
        </ol>
    </div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Welcome,<strong>{{$logged_user}}</strong><span class="float-end"> Total User: {{$total_users}}</span></div>
                <div class="card-body">
                    <table class="table table-bordered" id="user_table">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created_at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach ($all_users as $key=>$users)
                            <tbody>
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$users->name}}</td>
                                    <td>{{$users->email}}</td>
                                    <td>{{$users->created_at->diffForHumans()}}</td>
                                    <td>
                                        <a href="{{ url('/user/delete')}}/{{ $users->id }}" class="btn btn-danger delete shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')
    <script>
        $(document).ready( function () {
            $('#user_table').DataTable();
        } );
    </script>
    {{--  --}}
    <script>
        $('delete').click(function(){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                var link = $(this).attr('name');
                window.location.href = link;
                )
            }
            })
        });
    </script>
    @if (session('delete'))
        <script>
            Swal.fire(
      'Deleted!',
      '{{ session('delete')}}',
      'success'
    )
        </script>
    @endif
 
@endsection