@extends('website.layouts.app')
@section('title', 'Home ')
@section('content')
<style>
.offer-buttons {
    background-color: #ff9536 !important;
    background-image: unset !important;
}
.welome-screen {
        background: #feefd2 !important;
}
.border-bedige {
    color: #fdefd5 !important;
}
.orange-background {
    background-color: #ff9536 !important;
    background-image:unset !important;
}
.icon-green {
    background: #c9cb47 !important;
    color:#5e000b !important;
}
.red-background {
    background: #5e000b !important;
}
.red-color {
    color: #5e000b !important;
}
.text-teal {
    color: #60ff00 !important;
}
</style>
 <header class="page-header-ui page-header-ui-dark bg-gradient-primary-to-secondary orange-background">
<div class="page-header-ui-content pt-10">
<div class="container px-5">
    <div class="row gx-5 align-items-center">
        <div class="col-lg-6" data-aos="fade-up">
            <h1 class="page-header-ui-title">{{$homepage->top_header_heading}}</h1>
            <p class="page-header-ui-text mb-5">{{$homepage->top_header_subheading}}</p>
            <a class="btn btn-teal fw-500 me-2" href="{{$homepage->get_started_link}}">
                {{$homepage->get_started_label}}
                <i class="ms-2" data-feather="arrow-right"></i>
            </a>
        </div>
        <div class="col-lg-6 d-none d-lg-block" data-aos="fade-up" data-aos-delay="100">
            @if ($homepage->banner_image!='')
            <img class="img-fluid" src="{{url('public/uploads/images/'.$homepage->banner_image)}}" style="width: 70%;" />
            @endif
          </div>
    </div>
</div>
</div>
<div class="svg-border-rounded text-white">
<!-- Rounded SVG Border-->
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor" style="color: #feefd2;"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
</div>
</header>

<section class="bg-light py-10 welome-screen">
<div class="container px-5">
<div class="row gx-5 align-items-center justify-content-center">
    <div class="col-lg-12 order-0 order-lg-1 mb-12 mb-lg-0" data-aos="fade-left">
        <div class="mb-5">
            <h2>{{$homepage->welcome_lable}}</h2>
            @php
                echo $homepage->weclome_text;
            @endphp
        </div>
    </div>
</div>
</div>
</section>
<section class="bg-white py-10">
<div class="container px-5">
<div class="row gx-5 text-center">
    <div class="col-lg-12 mb-5 mb-lg-0">
        @php
            $offer_json = json_decode($homepage->offer_json, true);
        @endphp
        <h1>{{@$offer_json['offer_heading']}}</h1>
        <p>{{@$offer_json['offer_p1']}}</p>
        <p><b>{{@$offer_json['offer_p2']}}</b></p>
    </div>
    @if (isset($offer_json['offer_data_links'][0]))
    @foreach ($offer_json['offer_data_links'] as $key2=>$offerdata)
    <div class="col-lg-3 mb-5 mb-lg-0">
        <a href="{{url($offerdata['offer_link'])}}" style="text-decoration: none;">
        <div class="offer-buttons icon-stack icon-stack-xl bg-gradient-primary-to-secondary text-white mb-4"><i data-feather="{{$offerdata['offer_icon']}}"></i></div>
        <h3 style="font-size: 14px;"> {{$offerdata['name']}}</h3>
        </a>
    </div>
    @endforeach
    @endif
</div>
</div>
<div class="svg-border-rounded text-light border-bedige">
<!-- Rounded SVG Border-->
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor" style="color:#5e000b"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
</div>
</section>

<section class="bg-dark py-10 red-background ">
<div class="container px-5">
<div class="row gx-5 my-10">
    @php
        $qa_json = json_decode($homepage->qa_json, true);
    @endphp
    @foreach ($qa_json as $key=>$qa)
    <div class="col-lg-6 mb-5">
        <div class="d-flex h-100">
            <div class="icon-stack flex-shrink-0 bg-teal text-white icon-green"><i class="fas fa-question"></i></div>
            <div class="ms-4">
                <h5 class="text-white">{{@$qa['question']}}</h5>
                <p class="text-white-50">{{@$qa['answer']}}</p>
            </div>
        </div>
    </div>
    @endforeach
  
    
</div>
</div>
</section>
<hr class="m-0" />
@endsection