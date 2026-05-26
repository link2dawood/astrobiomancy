@section('title', 'Home Page')
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

                <div class="row m-b-40">
                    <div class="col-md-12">
                        <div class="well white">
                            <fieldset>
                                <legend>Home Page</legend>

                                <ul class="nav nav-tabs" role="tablist" style="margin-bottom:16px;">
                                    @foreach (['en' => 'English', 'de' => 'Deutsch'] as $code => $label)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                               data-bs-toggle="tab" data-toggle="tab"
                                               href="#home-{{ $code }}" role="tab">
                                                {{ strtoupper($code) }} — {{ $label }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach (['en' => 'English', 'de' => 'Deutsch'] as $code => $label)
                                        @php
                                            $row         = $rows[$code] ?? null;
                                            $qa          = ($row && $row->qa_json) ? json_decode($row->qa_json, true) : [];
                                            $qa          = is_array($qa) ? $qa : [];
                                            $offer       = ($row && $row->offer_json) ? json_decode($row->offer_json, true) : [];
                                            $offer       = is_array($offer) ? $offer : [];
                                            $offer_links = isset($offer['offer_data_links']) && is_array($offer['offer_data_links'])
                                                            ? $offer['offer_data_links'] : [];
                                        @endphp

                                        <div class="tab-pane {{ $loop->first ? 'active show' : '' }}" id="home-{{ $code }}" role="tabpanel">
                                            <form action="{{ url('/dashboard/pages/home_save') }}" method="POST" enctype="multipart/form-data">
                                                {{ Form::input('hidden', '_token', csrf_token()) }}
                                                <input type="hidden" name="_save_lang" value="{{ $code }}">

                                                {{-- Top hero --}}
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="control-label">Top Heading ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="top_header_heading[{{ $code }}]" class="form-control"
                                                               value="{{ $row->top_header_heading ?? '' }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label">Top Sub-heading ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="top_header_subheading[{{ $code }}]" class="form-control"
                                                               value="{{ $row->top_header_subheading ?? '' }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label">Banner image</label>
                                                        <input type="file" name="image">
                                                        @if (!empty($row->banner_image))
                                                            <div style="margin-top:4px;">
                                                                <img src="{{ url('public/uploads/images/' . $row->banner_image) }}" style="width:100px;" alt="">
                                                            </div>
                                                        @endif
                                                        <small class="text-muted d-block">Uploading replaces the image for this language only.</small>
                                                    </div>
                                                </div>

                                                {{-- CTA --}}
                                                <div class="row" style="margin-top:15px;">
                                                    <div class="col-md-4">
                                                        <label class="control-label">Get Started Label ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="get_started_label[{{ $code }}]" class="form-control"
                                                               value="{{ $row->get_started_label ?? '' }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label">Get Started Link ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="get_started_link[{{ $code }}]" class="form-control"
                                                               value="{{ $row->get_started_link ?? '' }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label">Welcome Label ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="welcome_lable[{{ $code }}]" class="form-control"
                                                               value="{{ $row->welcome_lable ?? '' }}">
                                                    </div>
                                                </div>

                                                {{-- Welcome text (rich) --}}
                                                <div class="row" style="margin-top:15px;">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Welcome Text ({{ strtoupper($code) }})</label>
                                                        <textarea class="form-control tinymce-home-{{ $code }}"
                                                                  name="weclome_text[{{ $code }}]" rows="6">{{ $row->weclome_text ?? '' }}</textarea>
                                                    </div>
                                                </div>

                                                {{-- Meta --}}
                                                <div class="row" style="margin-top:15px;">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Meta Title ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="meta_title[{{ $code }}]" class="form-control"
                                                               maxlength="70" value="{{ $row->meta_title ?? '' }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Meta Description ({{ strtoupper($code) }})</label>
                                                        <input type="text" name="meta_description[{{ $code }}]" class="form-control"
                                                               maxlength="160" value="{{ $row->meta_description ?? '' }}">
                                                    </div>
                                                </div>

                                                {{-- QA pairs --}}
                                                <div class="col-md-12" style="margin-top:24px;">
                                                    <hr>
                                                    <h5>Q&A pairs ({{ strtoupper($code) }})</h5>
                                                    <button type="button" class="btn btn-primary add-row-qa" data-lang="{{ $code }}">+ Add Question / Answer</button>
                                                </div>
                                                <div class="qa-data-{{ $code }}" style="margin: 12px 0;">
                                                    @foreach ($qa as $key => $pair)
                                                        <div class="row qa-row-{{ $code }}-{{ $key }}" style="margin:0;padding-top:6px;">
                                                            <div class="col-md-5">
                                                                <input type="text" name="question[{{ $code }}][]" class="form-control"
                                                                       placeholder="Question" value="{{ $pair['question'] ?? '' }}">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" name="answer[{{ $code }}][]" class="form-control"
                                                                       placeholder="Answer" value="{{ $pair['answer'] ?? '' }}">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-sm btn-danger qa-remove"
                                                                        data-lang="{{ $code }}" data-key="{{ $key }}">Remove</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                {{-- Offer section --}}
                                                <div class="col-md-12" style="margin-top:24px;">
                                                    <hr>
                                                    <h5>Offer section ({{ strtoupper($code) }})</h5>
                                                </div>
                                                <div class="row" style="margin-top:8px;">
                                                    <div class="col-md-6">
                                                        <label class="control-label">Offer Heading</label>
                                                        <input type="text" name="offer_heading[{{ $code }}]" class="form-control"
                                                               value="{{ $offer['offer_heading'] ?? '' }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label">Offer First Heading</label>
                                                        <input type="text" name="offer_p1[{{ $code }}]" class="form-control"
                                                               value="{{ $offer['offer_p1'] ?? '' }}">
                                                    </div>
                                                    <div class="col-md-6" style="margin-top:10px;">
                                                        <label class="control-label">Offer Second Heading</label>
                                                        <input type="text" name="offer_p2[{{ $code }}]" class="form-control"
                                                               value="{{ $offer['offer_p2'] ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-12" style="margin-top:15px;">
                                                    <button type="button" class="btn btn-primary add-row-offer" data-lang="{{ $code }}">+ Add Offer Link</button>
                                                </div>
                                                <div class="offer-data-{{ $code }}" style="margin: 12px 0;">
                                                    @foreach ($offer_links as $key2 => $oitem)
                                                        <div class="row offer-row-{{ $code }}-{{ $key2 }}" style="padding:0;margin:0;padding-top:6px;">
                                                            <div class="col-md-3">
                                                                <input type="text" name="offer_name[{{ $code }}][]" class="form-control"
                                                                       placeholder="Name" value="{{ $oitem['name'] ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" name="offer_link[{{ $code }}][]" class="form-control"
                                                                       placeholder="Link" value="{{ $oitem['offer_link'] ?? '' }}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="text" name="offer_icon[{{ $code }}][]" class="form-control"
                                                                       placeholder="Icon name" value="{{ $oitem['offer_icon'] ?? '' }}">
                                                                <a href="https://feathericons.com/" target="_blank">Icon names</a>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <button type="button" class="btn btn-sm btn-danger offer-remove"
                                                                        data-lang="{{ $code }}" data-key="{{ $key2 }}">Remove</button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="form-group" style="margin-top:24px;">
                                                    <button type="submit" class="btn btn-sm btn-primary">Save {{ strtoupper($code) }}</button>
                                                    <small class="text-muted" style="margin-left:1rem;">
                                                        Saves the {{ strtoupper($code) }} version only. The other language is untouched.
                                                    </small>
                                                </div>

                                                {{-- Seed per-tab counters for the dynamic add buttons --}}
                                                <script>
                                                    window.qaCount_{{ $code }}    = {{ count($qa) }};
                                                    window.offerCount_{{ $code }} = {{ count($offer_links) }};
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

<script charset="utf-8" src="{{ url('public/asserts/js/vendors.min.js') }}"></script>
<script charset="utf-8" src="{{ url('public/asserts/js/app.min.js') }}"></script>
<script src="https://cdn.tiny.cloud/1/i1klei5i485h8ijgmj8q78rbugybwoq5i98egx3u3ofngezi/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    if (typeof tinymce !== 'undefined') {
        ['en', 'de'].forEach(function (c) {
            tinymce.init({
                selector: 'textarea.tinymce-home-' + c,
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks | bold italic underline | link image media | numlist bullist | removeformat'
            });
        });
    }

    $('body').on('click', '.add-row-qa', function () {
        var lang = $(this).data('lang');
        var i = window['qaCount_' + lang]++;
        var html =
            '<div class="row qa-row-' + lang + '-' + i + '" style="margin:0;padding-top:6px;">' +
                '<div class="col-md-5"><input type="text" name="question[' + lang + '][]" class="form-control" placeholder="Question"></div>' +
                '<div class="col-md-5"><input type="text" name="answer[' + lang + '][]" class="form-control" placeholder="Answer"></div>' +
                '<div class="col-md-2"><button type="button" class="btn btn-sm btn-danger qa-remove" data-lang="' + lang + '" data-key="' + i + '">Remove</button></div>' +
            '</div>';
        $('.qa-data-' + lang).append(html);
    });

    $('body').on('click', '.qa-remove', function () {
        var lang = $(this).data('lang');
        var key  = $(this).data('key');
        $('.qa-row-' + lang + '-' + key).remove();
    });

    $('body').on('click', '.add-row-offer', function () {
        var lang = $(this).data('lang');
        var i = window['offerCount_' + lang]++;
        var html =
            '<div class="row offer-row-' + lang + '-' + i + '" style="padding:0;margin:0;padding-top:6px;">' +
                '<div class="col-md-3"><input type="text" name="offer_name[' + lang + '][]" class="form-control" placeholder="Name"></div>' +
                '<div class="col-md-3"><input type="text" name="offer_link[' + lang + '][]" class="form-control" placeholder="Link"></div>' +
                '<div class="col-md-3"><input type="text" name="offer_icon[' + lang + '][]" class="form-control" placeholder="Icon name"><a href="https://feathericons.com/" target="_blank">Icon names</a></div>' +
                '<div class="col-md-3"><button type="button" class="btn btn-sm btn-danger offer-remove" data-lang="' + lang + '" data-key="' + i + '">Remove</button></div>' +
            '</div>';
        $('.offer-data-' + lang).append(html);
    });

    $('body').on('click', '.offer-remove', function () {
        var lang = $(this).data('lang');
        var key  = $(this).data('key');
        $('.offer-row-' + lang + '-' + key).remove();
    });

    // Suppress Enter-as-submit on simple inputs (matches old behavior).
    $('form input').keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });
</script>
</body>
</html>
@include('backend.includes.footer')
