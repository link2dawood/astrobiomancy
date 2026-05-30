@extends('website.layouts.app')
@section('title', 'Home ')
@section('content')
<header class="page-header-ui page-header-ui-dark bg-gradient-primary-to-secondary" style="    background: #ff9536 !important;">
    <div class="page-header-ui-content pt-10">
        <div class="container px-5 text-center">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <h1 class="page-header-ui-title mb-0">{{ __('site.login_title') }}</h1>
                    <a href="{{ url(app()->getLocale() . '/create-account') }}" class="page-header-ui-text" style="color:white !important">{{ __('site.register_title') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="svg-border-rounded text-light">

        <!-- Rounded SVG Border-->

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor" style="color:#feefd2"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>

    </div>

</header>
<section class="bg-white " style="background: #feefd2 !important">
    <div class="container px-5">
        <form class="" action="{{url('user/login')}}" method="POST" onsubmit="return validate_form(this)">
            @csrf
            <div class="row gx-5 mb-4">
                <div class="col-md-12">
                    @if(session()->has('error'))
                    <br>
                    <div class="alert alert-danger">
                        {{session()->get('error')}}
                    </div>
                    @endif
                    @if(session()->has('success'))
                    <br>
                    <div class="alert alert-success">
                        {{session()->get('success')}}
                    </div>
                    @endif
                </div>
                

                <div class="col-md-6">
                    <br>
                    <label class="text-dark mb-2" for="inputEmail">{{ __('site.label_email') }}</label>

                    <input class="form-control py-4" id="inputEmail" type="email" placeholder="{{ __('site.ph_email') }}" name="email" />

                </div>
                <div class="col-md-6">
                    <br>
                    <label class="text-dark mb-2" for="inputEmail">{{ __('site.label_password') }}</label>
                    <input class="form-control py-4"  type="password" name="password" />

                </div>
                <div class="col-md-6">
                    <br>
                    <div class="g-recaptcha" data-sitekey="6LfM4nYqAAAAAPIWFdST6RQWSHIlqC8BeRliJcj3"></div>

                </div>

            </div>

            

            <div class="text-center"><button class="btn fw-500 ms-lg-4 btn-teal" type="submit">{{ __('site.btn_login') }}</button></div>

        </form>

    </div>

    <div class="svg-border-rounded text-dark">

        <!-- Rounded SVG Border-->

        <hr class="m-0 p-0">

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