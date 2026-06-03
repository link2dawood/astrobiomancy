@extends('website.layouts.app')
@section('title', __('site.register_title'))
@section('content')
<header class="page-header-ui page-header-ui-dark bg-gradient-primary-to-secondary" style="    background: #ff9536 !important;">
    <div class="page-header-ui-content pt-10">
        <div class="container px-5 text-center">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8">
                    <h1 class="page-header-ui-title mb-0">{{ __('site.register_title') }}</h1>
                    <a href="{{ url(app()->getLocale() . '/user/login') }}" class="page-header-ui-text" style="color:white !important">{{ __('site.already_have_account') }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="svg-border-rounded text-light">

        <!-- Rounded SVG Border-->

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 144.54 17.34" preserveAspectRatio="none" fill="currentColor" style="color:#feefd2"><path d="M144.54,17.34H0V0H144.54ZM0,0S32.36,17.34,72.27,17.34,144.54,0,144.54,0"></path></svg>

    </div>

</header>
<section class="bg-white pb-5" style="background: #feefd2 !important">
    <div class="container px-5">
        <form class="" action="{{url('create-account')}}" method="POST" onsubmit="return validate_form(this)">
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
                    @if ($errors->any())
                    <br>
                    <div class="alert alert-danger">
                        <ul style="margin:0; padding-left:1rem;">
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <br>
                    <label class="text-dark mb-2" for="inputName">{{ __('site.label_fullname') }}</label>

                    <input class="form-control py-4" id="inputName" type="text" placeholder="{{ __('site.ph_fullname') }}" name="name" />

                </div>

                <div class="col-md-6">
                    <br>
                    <label class="text-dark mb-2" for="inputEmail">{{ __('site.label_email') }}</label>

                    <input class="form-control py-4" id="inputEmail" type="email" placeholder="{{ __('site.ph_email') }}" name="email" />

                </div>
                <div class="col-md-6">
                    <label class="text-dark mb-2" for="inputEmail">{{ __('site.label_password') }}</label>
                    <input class="form-control py-4"  type="password" name="password" />

                </div>
            </div>

            <hr class="my-4">
            <h5 class="text-dark mb-3">{{ __('site.address_card_title') }}</h5>

            <div class="row gx-5 mb-4">
                <div class="col-md-6 mb-3">
                    <label class="text-dark mb-2">{{ __('site.label_first_name') }} *</label>
                    <input class="form-control py-4" type="text" name="first_name"
                           value="{{ old('first_name') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-dark mb-2">{{ __('site.label_last_name') }} *</label>
                    <input class="form-control py-4" type="text" name="last_name"
                           value="{{ old('last_name') }}" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="text-dark mb-2">{{ __('site.label_address') }} *</label>
                    <input class="form-control py-4" type="text" name="address"
                           value="{{ old('address') }}" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="text-dark mb-2">{{ __('site.label_address2') }}</label>
                    <input class="form-control py-4" type="text" name="address2"
                           value="{{ old('address2') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-dark mb-2">{{ __('site.label_city') }} *</label>
                    <input class="form-control py-4" type="text" name="city"
                           value="{{ old('city') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-dark mb-2">{{ __('site.label_zipcode') }} *</label>
                    <input class="form-control py-4" type="text" name="zipcode"
                           value="{{ old('zipcode') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-dark mb-2">{{ __('site.label_state') }} *</label>
                    <input class="form-control py-4" type="text" name="state"
                           value="{{ old('state') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="text-dark mb-2">{{ __('site.label_country') }} *</label>
                    <input class="form-control py-4" type="text" name="country"
                           value="{{ old('country') }}" required>
                </div>
            </div>

            <div class="row gx-5 mb-4">
                <div class="col-md-6">
                    <div class="g-recaptcha" data-sitekey="6LfM4nYqAAAAAPIWFdST6RQWSHIlqC8BeRliJcj3"></div>
                </div>
            </div>
            
            

            <div class="text-center"><button class="btn fw-500 ms-lg-4 btn-teal" type="submit">{{ __('site.btn_register') }}</button></div>

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