@extends('website.layouts.app')
@section('title', __('site.nav_account'))
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
                            <td>
                                @php $allowance = $order->package_number_of_question ?? $order->number_of_question; @endphp
                                @if ($allowance > 0)
                                    <a href="{{ url(app()->getLocale() . '/users/orders/' . $order->id) }}">{{ __('site.btn_ask_questions') }}</a>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@endsection