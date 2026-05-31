@extends('website.layouts.app')
@section('title', __('site.nav_testimonials'))
@section('meta_description', __('site.testimonials_meta'))
@section('content')

<header class="page-header-ui page-header-ui-dark bg-gradient-primary-to-secondary" style="background: #ff9536 !important;">
    <div class="page-header-ui-content pt-10">
        <div class="container px-5 text-center">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <h1 class="page-header-ui-title mb-3">{{ __('site.testimonials_title') }}</h1>
                    <p class="page-header-ui-text">{{ __('site.testimonials_subtitle') }}</p>
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

<section class="py-10" style="background: #feefd2 !important;">
    <div class="container px-5">
        @if ($testimonials->isEmpty())
            <p class="text-center text-muted">{{ __('site.testimonials_empty') }}</p>
        @else
            <div class="row gx-4 gy-4">
                @foreach ($testimonials as $t)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0" style="background:#fff; border-radius: 10px;">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="mb-3" style="color:#ff9536; font-size: 1.6rem; line-height: 1;">&ldquo;</div>
                                <p class="text-dark mb-4" style="font-style: italic; line-height: 1.6;">
                                    {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($t->content), ENT_QUOTES, 'UTF-8'), 320) }}
                                </p>
                                <div class="d-flex align-items-center mt-auto">
                                    @if ($t->photo)
                                        <img src="{{ url('public/uploads/testimonials/' . $t->photo) }}" alt=""
                                             style="width:56px;height:56px;border-radius:50%;object-fit:cover;margin-right:14px;">
                                    @else
                                        <div style="width:56px;height:56px;border-radius:50%;background:#ff9536;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:1.2rem;margin-right:14px;">
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

            <div class="mt-5 d-flex justify-content-center">
                {{ $testimonials->onEachSide(1)->links() }}
            </div>
        @endif
    </div>
</section>

@endsection
