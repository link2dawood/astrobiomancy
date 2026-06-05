@extends('website.layouts.app')
@section('title', __('site.nav_account'))
@section('content')
@php
    $L = app()->getLocale();
    $hero = \App\Models\Pages::where('slug', 'account-hero')->where('lang', $L)->first()
         ?: \App\Models\Pages::where('slug', 'account-hero')->where('lang', 'en')->first();
@endphp
@if ($hero)
<header class="page-header-ui page-header-ui-dark bg-gradient-primary-to-secondary" style="background: #ff9536 !important;">
    <div class="page-header-ui-content pt-10">
        <div class="container px-5 text-center">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <h1 class="page-header-ui-title mb-3">{{ $hero->main_heading }}</h1>
                    @if ($hero->second_heading)<p class="page-header-ui-text">{{ $hero->second_heading }}</p>@endif
                </div>
            </div>
        </div>
    </div>
    <div class="svg-border-rounded text-white">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor" style="color: #feefd2;">
            <path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path>
        </svg>
    </div>
</header>
@endif
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
</section>

@endsection