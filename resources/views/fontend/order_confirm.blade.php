@extends('fontend.master')

@section('content')
<!-- breadcrumb_section - start
================================================== -->
<div class="breadcrumb_section">
    <div class="container">
        <ul class="breadcrumb_nav ul_li">
            <li><a href="index.html">Home</a></li>
            <li>Order Confirm</li>
        </ul>
    </div>
</div>
<!-- breadcrumb_section - end
================================================== -->

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="my-5">
                    @if (session('order_success'))
                        <div class="alert alert-success py-5 text-center">
                            <h3>{{ session('order_success') }}</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>


@endsection