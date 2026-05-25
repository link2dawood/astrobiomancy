@section('title', 'Add Testimonial')
@include('backend.includes.head')
<body class="theme-template-dark theme-pink">
<main>
    @include('backend.includes.sidebar')
    <div class="main-container">
        @include('backend.includes.header')
        <div class="main-content" style="padding-top:0px">
            <section class="forms-basic">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="row m-b-40">
                    <div class="col-md-12">
                        <div class="well white">
                            <fieldset>
                                <legend>New testimonial</legend>
                                <form action="{{ url('dashboard/testimonials/store') }}" method="POST" enctype="multipart/form-data">
                                    {{ Form::input('hidden', '_token', csrf_token()) }}
                                    @include('backend.testimonials._form', ['item' => null])
                                    <div style="margin-top: 24px;">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                        <a href="{{ url('dashboard/testimonials') }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </form>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
<script charset="utf-8" src="{{url('public/asserts/js/vendors.min.js')}}"></script>
<script charset="utf-8" src="{{url('public/asserts/js/app.min.js')}}"></script>
</body>
</html>
@include('backend.includes.footer')
