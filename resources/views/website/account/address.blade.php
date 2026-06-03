@extends('website.layouts.app')
@section('title', __('site.nav_address'))
@section('content')
<section class="bg-light pt-15" style="background: #feefd2 !important">
<div class="container px-5">
    <div class="row gx-5">
        @include('website.account.sidebar')
        <div class="col-lg-8 col-xl-9">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin:0; padding-left:1rem;">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header" style="color: #4a515b;">{{ __('site.address_card_title') }}</div>
                <div class="card-body">
                    <form action="{{ url(app()->getLocale() . '/users/address') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label class="mb-2">{{ __('site.label_first_name') }} *</label>
                                <input type="text" name="first_name" class="form-control"
                                       value="{{ old('first_name', $user->first_name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-2">{{ __('site.label_last_name') }} *</label>
                                <input type="text" name="last_name" class="form-control"
                                       value="{{ old('last_name', $user->last_name) }}" required>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label class="mb-2">{{ __('site.label_address') }} *</label>
                                <input type="text" name="address" class="form-control"
                                       value="{{ old('address', $user->address) }}" required>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label class="mb-2">{{ __('site.label_address2') }}</label>
                                <input type="text" name="address2" class="form-control"
                                       value="{{ old('address2', $user->address2) }}">
                                <small class="text-muted">{{ __('site.hint_address2') }}</small>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="mb-2">{{ __('site.label_city') }} *</label>
                                <input type="text" name="city" class="form-control"
                                       value="{{ old('city', $user->city) }}" required>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="mb-2">{{ __('site.label_zipcode') }} *</label>
                                <input type="text" name="zipcode" class="form-control"
                                       value="{{ old('zipcode', $user->zipcode) }}" required>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="mb-2">{{ __('site.label_state') }} *</label>
                                <input type="text" name="state" class="form-control"
                                       value="{{ old('state', $user->state) }}" required>
                            </div>
                            <div class="col-md-6 mt-3">
                                <label class="mb-2">{{ __('site.label_country') }} *</label>
                                <input type="text" name="country" class="form-control"
                                       value="{{ old('country', $user->country) }}" required>
                            </div>
                            <div class="col-md-12 mt-4">
                                <button class="btn fw-500 btn-teal" type="submit">{{ __('site.btn_save') }}</button>
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
