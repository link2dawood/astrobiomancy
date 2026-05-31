@extends('website.layouts.app')

@section('title', 'Posts ')
@section('content')
<style>
.bg-light {
    background: #feefd2 !important;
}
.page-link.active, .active > .page-link {
    background-color : #c9cb47 !important;
    color: #5e000b !important;
        border-color: #c6bdaa;
}
.page-link {
    color: #5e000b !important;
        border-color: #c6bdaa;

}
.page-link:hover {
    background: #60ff00 !important;
    color: #5e000b !important;
}
.pagination {
        justify-content: center !important;
}
</style>
<!-- Page Header-->
<header class="page-header-ui page-header-ui-dark bg-gradient-primary-to-secondary" style="background: #ff9536 !important;">
    <div class="page-header-ui-content pt-10">
        <div class="container px-5 text-center">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <h1 class="page-header-ui-title mb-3">{{ __('site.nav_blog') }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="svg-border-rounded text-light">
        <!-- Rounded SVG Border-->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor" style="color:#feefd2"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>
    </div>
</header>
<section class="bg-light py-10 mt-0 pb-0">
    <div class="container px-5">
       
        <div class="row gx-5">
            @foreach ($posts as $post)
            <div class="col-md-6 col-xl-4 mb-5">
                <a class="card post-preview lift h-100" href="{{url('post/'.$post->slug)}}">
                    <img class="card-img-top" src="{{url('/public/uploads/images/'.$post->image)}}"  />
                    <div class="card-body">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <p class="card-text">
                            {{ \Illuminate\Support\Str::limit(trim(html_entity_decode(strip_tags($post->description), ENT_QUOTES, 'UTF-8')), 150) }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="post-preview-meta">
                           
                            <div class="post-preview-meta-details">
                                <div class="post-preview-meta-details-name">{{@$post->author_data->name}}</div>
                                <div class="post-preview-meta-details-date">{{date('M d Y', strtotime($post->created_at))}}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        
            
        </div>
        <nav aria-label="Page navigation example">
           <center> {{ $posts->onEachSide(1)->links() }}</center>

        </nav>
    </div>
    <div class="svg-border-rounded text-dark">
        <!-- Rounded SVG Border-->
        <hr class="m-0">
    </div>
</section>
@endsection
            