@section('title', 'Add Menu Item')
@include('backend.includes.head')
<body class="theme-template-dark theme-pink">
<main>
    @include('backend.includes.sidebar')
    <div class="main-container">
        @include('backend.includes.header')
        <div class="main-content" style="padding-top:0px">
            <section class="forms-basic">
                <div class="row m-b-40">
                    <div class="col-md-12">
                        <div class="well white">
                            <fieldset>
                                <legend>New menu item</legend>
                                <form action="{{ url('dashboard/menus/store') }}" method="POST">
                                    {{ Form::input('hidden', '_token', csrf_token()) }}
                                    @include('backend.menus._form', ['item' => null])
                                    <div style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                        <a href="{{ url('dashboard/menus') }}" class="btn btn-secondary">Cancel</a>
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
