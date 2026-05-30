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
                <div class="card-header" style="color: #4a515b;">Update Profile</div>
                <div class="card-body">
                    <form action="{{url('users/accountupdate')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label>{{ __('site.label_name') }}</label>
                            <input type="text" name="name" class="form-control"  value="{{Auth::user()->name}}">
                        </div>
                        <div class="col-md-12">
                            <label>{{ __('site.label_email') }}</label>
                            <input type="email" name="email" class="form-control" value="{{Auth::user()->email}}" readonly>
                        </div>
                        <div class="col-md-12">
                            <label>{{ __('site.label_password') }}</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <button class="btn fw-500 btn-teal mt-2" type="submit">{{ __('site.btn_update') }}</button>
                        </div>
                    </div>
                    </form>
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