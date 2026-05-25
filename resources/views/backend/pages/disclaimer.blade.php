@section('title', 'Disclaimer')
@include('backend.includes.head')
<body class="theme-template-dark theme-pink">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<main>
    @include('backend.includes.sidebar')
    <div class="main-container">
        @include('backend.includes.header')
        <div class="main-content" style="padding-top:0px">
            <section class="forms-basic">
                @if(session()->has('message'))
                    <div class="alert alert-success">Saved.</div>
                @endif
                <div class="row m-b-40">
                    <div class="col-md-12">
                        <div class="well white">
                            @include('backend.pages._translatable_singleton', [
                                'rows'       => $rows,
                                'action_url' => url('/dashboard/pages/disclaimer_save'),
                                'title'      => 'Disclaimer',
                            ])
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
<script charset="utf-8" src="{{url('public/asserts/js/vendors.min.js')}}"></script>
<script charset="utf-8" src="{{url('public/asserts/js/app.min.js')}}"></script>
<script src="https://cdn.tiny.cloud/1/i1klei5i485h8ijgmj8q78rbugybwoq5i98egx3u3ofngezi/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
@stack('scripts')
</body>
</html>
@include('backend.includes.footer')
