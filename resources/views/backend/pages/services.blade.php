@section('title', 'Service Page')
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
                    <div class="alert alert-success">Saved. Other language was not touched.</div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger">{{ session()->get('error') }}</div>
                @endif

                <div class="row m-b-40">
                    <div class="col-md-12">
                        <div class="well white">
                            <fieldset>
                                <legend>Service: <code>{{ $slug }}</code></legend>

                                <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 16px;">
                                    @foreach (['en' => 'English', 'de' => 'Deutsch'] as $code => $label)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                               data-bs-toggle="tab" data-toggle="tab"
                                               href="#svc-{{ $code }}" role="tab">
                                                {{ strtoupper($code) }} — {{ $label }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach (['en' => 'English', 'de' => 'Deutsch'] as $code => $label)
                                        @php $row = $rows[$code] ?? null; @endphp
                                        <div class="tab-pane {{ $loop->first ? 'active show' : '' }}" id="svc-{{ $code }}" role="tabpanel">
                                            <form action="{{ url('dashboard/services/save') }}" method="POST" enctype="multipart/form-data">
                                                {{ Form::input('hidden', '_token', csrf_token()) }}
                                                <input type="hidden" name="slug" value="{{ $slug }}">
                                                <input type="hidden" name="_save_lang" value="{{ $code }}">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Main Heading ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="main_heading[{{ $code }}]" class="form-control"
                                                               value="{{ $row->main_heading ?? '' }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Second Heading ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="second_heading[{{ $code }}]" class="form-control"
                                                               value="{{ $row->second_heading ?? '' }}">
                                                    </div>
                                                    <div class="col-md-12" style="margin-top:15px">
                                                        <label class="control-label">Description ({{ strtoupper($code) }})</label>
                                                        <textarea class="form-control tinymce-svc-{{ $code }}"
                                                                  name="description[{{ $code }}]" rows="10">{{ $row->description ?? '' }}</textarea>
                                                    </div>
                                                    <div class="col-md-6" style="margin-top:15px">
                                                        <label class="control-label">Meta Title ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="meta_title[{{ $code }}]" class="form-control"
                                                               maxlength="70" value="{{ $row->meta_title ?? '' }}">
                                                    </div>
                                                    <div class="col-md-6" style="margin-top:15px">
                                                        <label class="control-label">Meta Description ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="meta_description[{{ $code }}]" class="form-control"
                                                               maxlength="160" value="{{ $row->meta_description ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="form-group" style="margin-top:20px">
                                                    <button type="submit" class="btn btn-sm btn-primary">Save {{ strtoupper($code) }}</button>
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
                selector: 'textarea.tinymce-svc-' + c,
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks | bold italic underline | link image media | numlist bullist | removeformat',
            });
        });
    }
</script>
</body>
</html>
@include('backend.includes.footer')
