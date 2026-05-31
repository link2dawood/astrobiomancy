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
                                        @php
                                            $row = $rows[$code] ?? null;
                                            $packages = ($row && $row->packages_details)
                                                ? (is_string($row->packages_details) ? json_decode($row->packages_details, true) : $row->packages_details)
                                                : [];
                                            $packages = is_array($packages) ? $packages : [];

                                            // If the DE tab has no packages of its own, seed from the EN tab so editors
                                            // see the existing structure and can translate the labels.
                                            if (empty($packages) && $code !== 'en' && isset($rows['en']) && $rows['en']->packages_details) {
                                                $seed = json_decode($rows['en']->packages_details, true);
                                                if (is_array($seed)) {
                                                    $packages = $seed;
                                                }
                                            }
                                        @endphp
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

                                                {{-- Packages editor (per language) --}}
                                                <hr style="margin: 24px 0 16px;">
                                                <div class="d-flex justify-content-between align-items-center" style="margin-bottom:8px;">
                                                    <h5 style="margin:0;">Packages ({{ strtoupper($code) }})</h5>
                                                    <button type="button" class="btn btn-sm btn-primary add-pkg" data-lang="{{ $code }}">+ Add package</button>
                                                </div>
                                                <small class="text-muted d-block" style="margin-bottom:12px;">
                                                    Each row is one purchasable option. Group rows under the same <em>Package name</em> to make them appear together on the public page.
                                                </small>

                                                <div class="pkg-list-{{ $code }}">
                                                    @foreach ($packages as $key => $pkg)
                                                        <div class="card pkg-row-{{ $code }}-{{ $key }}" style="margin-bottom:12px; padding:12px; background:#fafafa;">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <label class="control-label">Package name</label>
                                                                    <input type="text" name="package_name[{{ $code }}][]" class="form-control"
                                                                           value="{{ $pkg['package_name'] ?? '' }}" placeholder="e.g. Energy work (full session)">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="control-label">Details (line shown to buyer)</label>
                                                                    <input type="text" name="package_details[{{ $code }}][]" class="form-control"
                                                                           value="{{ $pkg['package_details'] ?? '' }}" placeholder="e.g. 45 minutes: 80 Euro">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label class="control-label">Amount</label>
                                                                    <input type="text" name="package_amount[{{ $code }}][]" class="form-control"
                                                                           value="{{ $pkg['package_amount'] ?? '' }}" placeholder="80">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label class="control-label">Questions</label>
                                                                    <input type="number" name="number_of_question[{{ $code }}][]" class="form-control"
                                                                           value="{{ $pkg['number_of_question'] ?? '' }}" placeholder="1">
                                                                </div>
                                                                <div class="col-md-6" style="margin-top:10px;">
                                                                    <label class="control-label">Terms / fine print</label>
                                                                    <input type="text" name="package_details_terms[{{ $code }}][]" class="form-control"
                                                                           value="{{ $pkg['package_details_terms'] ?? '' }}">
                                                                </div>
                                                                <div class="col-md-3" style="margin-top:10px;">
                                                                    <label class="control-label">Package ID</label>
                                                                    <input type="text" name="package_id[{{ $code }}][]" class="form-control"
                                                                           value="{{ $pkg['package_id'] ?? '' }}">
                                                                </div>
                                                                <div class="col-md-3" style="margin-top:10px;">
                                                                    <label class="control-label">Customer question page</label>
                                                                    <input type="text" name="customer_ask_question_page[{{ $code }}][]" class="form-control"
                                                                           value="{{ $pkg['customer_ask_question_page'] ?? '' }}">
                                                                </div>
                                                                <div class="col-md-12" style="margin-top:10px; text-align:right;">
                                                                    <button type="button" class="btn btn-sm btn-danger pkg-remove" data-lang="{{ $code }}" data-key="{{ $key }}">Remove this package</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="form-group" style="margin-top:20px">
                                                    <button type="submit" class="btn btn-sm btn-primary">Save {{ strtoupper($code) }}</button>
                                                    <small class="text-muted" style="margin-left:1rem">
                                                        Saves the {{ strtoupper($code) }} version only — including its packages.
                                                    </small>
                                                </div>

                                                <script>
                                                    window.pkgCount_{{ $code }} = {{ count($packages) }};
                                                </script>
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

    document.addEventListener('click', function (e) {
        var addBtn = e.target.closest('.add-pkg');
        if (addBtn) {
            var lang = addBtn.getAttribute('data-lang');
            var i = window['pkgCount_' + lang]++;
            var html =
                '<div class="card pkg-row-' + lang + '-' + i + '" style="margin-bottom:12px; padding:12px; background:#fafafa;">' +
                  '<div class="row">' +
                    '<div class="col-md-4"><label class="control-label">Package name</label>' +
                      '<input type="text" name="package_name[' + lang + '][]" class="form-control" placeholder="e.g. Energy work (full session)"></div>' +
                    '<div class="col-md-4"><label class="control-label">Details (line shown to buyer)</label>' +
                      '<input type="text" name="package_details[' + lang + '][]" class="form-control" placeholder="e.g. 45 minutes: 80 Euro"></div>' +
                    '<div class="col-md-2"><label class="control-label">Amount</label>' +
                      '<input type="text" name="package_amount[' + lang + '][]" class="form-control"></div>' +
                    '<div class="col-md-2"><label class="control-label">Questions</label>' +
                      '<input type="number" name="number_of_question[' + lang + '][]" class="form-control"></div>' +
                    '<div class="col-md-6" style="margin-top:10px;"><label class="control-label">Terms / fine print</label>' +
                      '<input type="text" name="package_details_terms[' + lang + '][]" class="form-control"></div>' +
                    '<div class="col-md-3" style="margin-top:10px;"><label class="control-label">Package ID</label>' +
                      '<input type="text" name="package_id[' + lang + '][]" class="form-control"></div>' +
                    '<div class="col-md-3" style="margin-top:10px;"><label class="control-label">Customer question page</label>' +
                      '<input type="text" name="customer_ask_question_page[' + lang + '][]" class="form-control"></div>' +
                    '<div class="col-md-12" style="margin-top:10px; text-align:right;">' +
                      '<button type="button" class="btn btn-sm btn-danger pkg-remove" data-lang="' + lang + '" data-key="' + i + '">Remove this package</button></div>' +
                  '</div>' +
                '</div>';
            document.querySelector('.pkg-list-' + lang).insertAdjacentHTML('beforeend', html);
            return;
        }
        var rmBtn = e.target.closest('.pkg-remove');
        if (rmBtn) {
            var lang = rmBtn.getAttribute('data-lang');
            var key  = rmBtn.getAttribute('data-key');
            var card = document.querySelector('.pkg-row-' + lang + '-' + key);
            if (card) card.remove();
        }
    });
</script>
</body>
</html>
@include('backend.includes.footer')
