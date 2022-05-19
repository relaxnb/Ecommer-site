@extends('layouts.dashboard')

@section('content')
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Coupon</a></li>
        </ol>
    </div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Coupon</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/coupon/insert')}}" method="POST">
                        @csrf
                        <div class="mt-3">
                            <label for="form-label">Coupon Name</label>
                            <input type="text" name="coupon_name" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="form-label">Coupon discount %</label>
                            <input type="text" name="discount" class="form-control">
                        </div>
                        <div class="mt-3">
                            <label for="form-label">Coupon Validity</label>
                            <input type="date" name="validity" class="form-control">
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Add Coupon</button>
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
                   <table class="table table-hover">
                            <thead class="thead-primary">
                                <tr>
                                    <th>SL</th>
                                    <th>Coupon Name</th>
                                    <th>Discount %</th>
                                    <th>Validity</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            @forelse ($coupons as $key=>$coupon )
                            <tbody>
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$coupon->coupon_name}}</td>
                                    <td>{{$coupon->discount}}</td>
                                    <td>{{$coupon->validity}}</td>
                                    <td>{{$coupon->created_at->diffForHumans()}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Category Data Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection