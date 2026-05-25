@extends('website.layouts.app')
@section('title', 'User Account ')
@section('content')
<section class="bg-light pt-15 " style="background: #feefd2 !important">
<div class="container px-5">
    <div class="row gx-5">
        @include('website.account.sidebar')
        <div class="col-lg-8 col-xl-9">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{session()->get('message')}}
                </div>
            @endif
        
            <div class="card mb-4" >
                <div class="card-header" style="color: #4a515b;">Orders</div>
                <div class="card-body">
                    <table class="table table-responsive">
                        <tr>
                            <th>Service</th>
                            <th>Package Name</th>
                            <th># Of Questions</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($orders as $order)
                        <tr>
                            <td>{{@$order->servicesdata->main_heading}}</td>
                            <td>{{$order->package_name}}</td>
                            <td>{{$order->number_of_question}}</td>
                            <td>{{number_format($order->package_amount, 2)}}EUR</td>
                            <td><a href="{{url('/users/orders/'.$order->id)}}">Ask Questions</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="svg-border-rounded text-dark">
    <!-- Rounded SVG Border-->
   <hr class="m-0 p-0">
   <br>
</div>
</section>

@endsection