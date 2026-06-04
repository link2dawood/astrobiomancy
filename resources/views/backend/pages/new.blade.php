@section('title', 'New page')
@include('backend.includes.head')
<body class="theme-template-dark theme-pink">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<main>
    @include('backend.includes.sidebar')
    <div class="main-container">
        @include('backend.includes.header')
        <div class="main-content" style="padding-top:0px">
            <section class="forms-basic">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin:0; padding-left:1rem;">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">{{ session()->get('error') }}</div>
                @endif

                <div class="row m-b-40">
                    <div class="col-md-12">
                        <div class="well white">
                            <fieldset>
                                <legend>Create new page</legend>
                                <p class="text-muted">
                                    Enter a title and a URL slug. After creating, you'll land on the editor where you
                                    can fill in the English content (and add a German translation in the DE tab).
                                </p>
                                <form action="{{ url('dashboard/pages-create') }}" method="POST">
                                    {{ Form::input('hidden', '_token', csrf_token()) }}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">Title (English heading)</label>
                                            <input type="text" name="title" class="form-control"
                                                   value="{{ old('title') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">URL slug</label>
                                            <input type="text" name="slug" class="form-control"
                                                   value="{{ old('slug') }}"
                                                   pattern="[a-z0-9\-]+"
                                                   placeholder="e.g. my-new-page"
                                                   required>
                                            <small class="text-muted">Lowercase, dashes between words.</small>
                                        </div>
                                    </div>
                                    <div style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary">Create page</button>
                                        <a href="{{ url('dashboard/pages') }}" class="btn btn-secondary">Cancel</a>
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
