@extends('website.layouts.app')

@section('title', 'Posts ')
@section('page_meta')
<meta name="keywords" content="{{$post->meta_keyword}}">
<meta name="description" content="{{$post->description}}">

@endsection
@section('content')
<style>
    .bg-light {
        background: #feefd2 !important;
    }

</style>
<section class="bg-light py-10 mt-5 pb-0">
    <div class="container px-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="single-post">
                    <h1>{{$post->title}}</h1>
                    
                    <div class="d-flex align-items-center justify-content-between mb-5">
                        <div class="single-post-meta me-4">
                          
                            <div class="single-post-meta-details">
                                <div class="single-post-meta-details-name">{{@$post->author_data->name}}</div>
                                <div class="single-post-meta-details-date">{{date('M d Y', strtotime($post->created_at))}}</div>
                            </div>
                        </div>
                        
                    </div>
                    <img class="img-fluid mb-2 rounded" src="{{url('/public/uploads/images/'.$post->image)}}">
                    <div class="single-post-text my-5">
                        @php
                        echo $post->description;
                        @endphp
                    </div>
                </div>
            </div>
            <div class="col-lg-10 col-xl-8">
                <div class="post-archive-tag mb-3">Comments</div>
                @if (session()->has('success'))
                {{session()->get('success')}}
                @endif
                <form action="{{url('post-comment')}}" method="POST" onsubmit="return validate_form(this)">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-dark mb-2" for="inputName">{{ __('site.label_fullname') }}</label>
                            <input class="form-control py-4" type="text" name="fullname" placeholder="{{ __('site.ph_fullname') }}" required/>
                        </div>
                        <div class="col-md-6">
                            <label class="text-dark mb-2" for="inputName">{{ __('site.label_email') }}</label>
                            <input class="form-control py-4" type="email" name="email" placeholder="{{ __('site.ph_email') }}" required />
                            <input class="form-control py-4" type="hidden" name="post_id" value="{{$post->id}}" />
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="text-dark mb-2" for="inputName">{{ __('site.label_comment') }}</label>
                            <textarea class="form-control" name="comments" required></textarea>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="g-recaptcha" data-sitekey="6LfM4nYqAAAAAPIWFdST6RQWSHIlqC8BeRliJcj3"></div>
                        </div>
                        <div class="col-md-12 mt-2">
                           <div class="text-center"><button class="btn btn-primary mt-4" type="submit">{{ __('site.btn_post_comment') }}</button></div>
                       </div>
                   </div>
               </form>
               <hr class="my-5">
               @foreach ($comments as $coment)
               <a class="post-archive-item" href="#!">
                <h5>{{$coment->comment}}</h5>
                
            </a>
            <div class="post-archive-meta">
                
                <div class="post-archive-meta-details">
                    <div class="post-archive-meta-details-name">{{$coment->fullname}}</div>
                    <div class="post-archive-meta-details-date">{{date('M Y D', strtotime($coment->created_at))}}</div>
                </div>
            </div>
            <hr class="my-5">
            @endforeach
        </div>
    </div>
</div>
<div class="svg-border-rounded text-dark">
    <!-- Rounded SVG Border-->
    <hr class="m-0">
</div>
</section>

<script src='https://www.google.com/recaptcha/api.js'></script>
<script type="text/javascript">
 function validate_form(thisform){
     if (grecaptcha.getResponse() == ""){
         alert("You can't proceed! Fill the Captcha Field");
         return false;
     }
 }
</script>
@endsection
