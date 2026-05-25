@extends('website.layouts.app')
@section('title', 'About Us ')
@section('content')
<header class="page-header-ui page-header-ui-dark bg-gradient-primary-to-secondary" style="    background: #ff9536 !important;">
<div class="page-header-ui-content pt-10">
    <div class="container px-5 text-center">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-8">
                <h1 class="page-header-ui-title mb-3">{{$privacypolicy->main_heading}}</h1>
                <p class="page-header-ui-text">{{$privacypolicy->second_heading}}</p>
            </div>
        </div>
    </div>
</div>
<div class="svg-border-rounded text-white">
    <!-- Rounded SVG Border-->
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor" style="color: #feefd2 ;"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
</div>
</header>
<section class="bg-white py-10" style="background: #feefd2 !important">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-10">
                    @php
                        echo $privacypolicy->description;
                    @endphp
                </div>
            </div>
        </div>
        <div class="svg-border-rounded text-dark">
        <!-- Rounded SVG Border-->
        <hr class="m-0">
    </div>
</section>
@endsection