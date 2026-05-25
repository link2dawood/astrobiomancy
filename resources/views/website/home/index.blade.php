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

@if (!empty($testimonials) && $testimonials->isNotEmpty())
<section class="py-10" style="background:#feefd2;">
    <div class="container px-5">
        <div class="text-center mb-5">
            <h2 style="color:#5e000b;">{{ __('site.testimonials_title') }}</h2>
            <p class="text-muted">{{ __('site.testimonials_subtitle') }}</p>
        </div>

        <div id="testimonialsSlider" class="carousel slide" data-bs-ride="carousel" data-ride="carousel" data-bs-interval="6000">
            <div class="carousel-inner">
                @foreach ($testimonials->chunk(2) as $idx => $chunk)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row gx-4 justify-content-center">
                            @foreach ($chunk as $t)
                                <div class="col-md-5">
                                    <div class="card border-0 shadow-sm h-100" style="border-radius:10px; background:#fff;">
                                        <div class="card-body p-4">
                                            <div style="color:#ff9536; font-size:1.6rem; line-height:1;">&ldquo;</div>
                                            <p class="text-dark" style="font-style:italic; line-height:1.6;">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($t->content), 260) }}
                                            </p>
                                            <div class="d-flex align-items-center mt-3">
                                                @if ($t->photo)
                                                    <img src="{{ url('public/uploads/testimonials/' . $t->photo) }}" alt=""
                                                         style="width:48px;height:48px;border-radius:50%;object-fit:cover;margin-right:12px;">
                                                @else
                                                    <div style="width:48px;height:48px;border-radius:50%;background:#ff9536;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:600;margin-right:12px;">
                                                        {{ strtoupper(mb_substr($t->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div style="font-weight:600; color:#5e000b;">{{ $t->name }}</div>
                                                    @if ($t->display_date)
                                                        <div class="small text-muted">{{ $t->display_date->translatedFormat('F Y') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($testimonials->count() > 2)
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsSlider" data-target="#testimonialsSlider" data-bs-slide="prev" data-slide="prev" style="width: 5%;">
                    <span class="carousel-control-prev-icon" style="filter: invert(1);" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialsSlider" data-target="#testimonialsSlider" data-bs-slide="next" data-slide="next" style="width: 5%;">
                    <span class="carousel-control-next-icon" style="filter: invert(1);" aria-hidden="true"></span>
                </button>
            @endif
        </div>

        <div class="text-center mt-5">
            <a class="btn btn-teal" href="{{ url(app()->getLocale() . '/testimonials') }}">{{ __('site.testimonials_view_all') }}</a>
        </div>
    </div>
</section>
@endif

@endsection