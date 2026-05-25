@section('title', 'Page')
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
                            <fieldset>
                                <legend>Page: <code>{{ $slug }}</code></legend>

                                <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 16px;">
                                    @foreach (['en' => 'English', 'de' => 'Deutsch'] as $code => $label)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                               data-bs-toggle="tab" data-toggle="tab"
                                               href="#page-{{ $code }}" role="tab">
                                                {{ strtoupper($code) }} — {{ $label }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach (['en' => 'English', 'de' => 'Deutsch'] as $code => $label)
                                        @php $page = $pages[$code] ?? null; @endphp
                                        <div class="tab-pane {{ $loop->first ? 'active show' : '' }}" id="page-{{ $code }}" role="tabpanel">

                                            <form action="{{ url('/dashboard/pages/update') }}" method="POST" enctype="multipart/form-data">
                                                {{ Form::input('hidden', '_token', csrf_token()) }}
                                                <input type="hidden" name="id" value="{{ $page->id ?? '' }}">
                                                <input type="hidden" name="_save_lang" value="{{ $code }}">

                                                @if(empty($page) || empty($page->id))
                                                    <div class="alert alert-warning">
                                                        No <strong>{{ strtoupper($code) }}</strong> version of this page exists yet.
                                                        Saving below will fail — create the row first via the database or the generic page-create flow.
                                                        (Tip: copy the EN row and change <code>lang</code>.)
                                                    </div>
                                                @endif

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Main Heading ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="main_heading" class="form-control"
                                                               value="{{ $page->main_heading ?? '' }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Second Heading ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="second_heading" class="form-control"
                                                               value="{{ $page->second_heading ?? '' }}">
                                                    </div>
                                                    <div class="col-md-12" style="margin-top:15px">
                                                        <label class="control-label">Content ({{ strtoupper($code) }})</label>
                                                        <textarea class="form-control tinymce-page-{{ $code }}"
                                                                  name="description" rows="10">{{ $page->description ?? '' }}</textarea>
                                                    </div>
                                                    <div class="col-md-6" style="margin-top:15px">
                                                        <label class="control-label">Meta Title ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="meta_title" class="form-control"
                                                               maxlength="70" value="{{ $page->meta_title ?? '' }}">
                                                    </div>
                                                    <div class="col-md-6" style="margin-top:15px">
                                                        <label class="control-label">Meta Description ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="meta_description" class="form-control"
                                                               maxlength="160" value="{{ $page->meta_description ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="form-group" style="margin-top:20px">
                                                    <button type="submit" class="btn btn-sm btn-primary" {{ empty($page->id) ? 'disabled' : '' }}>
                                                        Save {{ strtoupper($code) }}
                                                    </button>
                                                    <small class="text-muted" style="margin-left:1rem">
                                                        Saves the {{ strtoupper($code) }} version only.
                                                    </small>
                                                </div>
                                            </form>

                                        </div>
                                    @endforeach
                                </div>
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
<script src="https://cdn.tiny.cloud/1/i1klei5i485h8ijgmj8q78rbugybwoq5i98egx3u3ofngezi/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    if (typeof tinymce !== 'undefined') {
        ['en', 'de'].forEach(function (c) {
            tinymce.init({
                selector: 'textarea.tinymce-page-' + c,
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks | bold italic underline | link image media | numlist bullist | removeformat',
            });
        });
    }
</script>
</body>
</html>
@include('backend.includes.footer')
