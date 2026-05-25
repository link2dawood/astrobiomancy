{{--
    Side-by-side EN / DE editor for a singleton page (about, disclaimer, privacy).

    Each language tab is its own <form>. Saving EN posts ONLY EN inputs,
    so the controller cannot accidentally overwrite DE (and vice versa).

    Expects:
      $rows       array<string, Model>  keyed by locale ('en', 'de')
      $action_url string                 form POST target
      $title      string                 fieldset legend
--}}
@php
    $locales = $locales ?? ['en' => 'English', 'de' => 'Deutsch'];
@endphp

<fieldset>
    <legend>{{ $title }}</legend>

    <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 16px;">
        @foreach ($locales as $code => $label)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                   data-bs-toggle="tab"
                   data-toggle="tab"
                   href="#lang-{{ $code }}"
                   role="tab">{{ strtoupper($code) }} — {{ $label }}</a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content">
        @foreach ($locales as $code => $label)
            @php $row = $rows[$code] ?? null; @endphp
            <div class="tab-pane {{ $loop->first ? 'active show' : '' }}" id="lang-{{ $code }}" role="tabpanel">

                <form action="{{ $action_url }}" method="POST" enctype="multipart/form-data">
                    {{ Form::input('hidden', '_token', csrf_token()) }}
                    <input type="hidden" name="_save_lang" value="{{ $code }}">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Main Heading ({{ strtoupper($code) }})</label>
                                <input type="text" name="main_heading[{{ $code }}]" class="form-control"
                                       value="{{ $row->main_heading ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Second Heading ({{ strtoupper($code) }})</label>
                                <input type="text" name="second_heading[{{ $code }}]" class="form-control"
                                       value="{{ $row->second_heading ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top:15px">
                            <div class="form-group">
                                <label class="control-label">Content ({{ strtoupper($code) }})</label>
                                <textarea class="form-control tinymce-content"
                                          name="description[{{ $code }}]"
                                          rows="10">{{ $row->description ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-top:15px">
                            <div class="form-group">
                                <label class="control-label">Meta Title ({{ strtoupper($code) }})</label>
                                <input type="text" name="meta_title[{{ $code }}]" class="form-control"
                                       maxlength="70"
                                       value="{{ $row->meta_title ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-top:15px">
                            <div class="form-group">
                                <label class="control-label">Meta Description ({{ strtoupper($code) }})</label>
                                <input type="text" name="meta_description[{{ $code }}]" class="form-control"
                                       maxlength="160"
                                       value="{{ $row->meta_description ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top:20px">
                        <button type="submit" class="btn btn-sm btn-primary">Save {{ strtoupper($code) }}</button>
                        <small class="text-muted" style="margin-left:1rem">
                            This saves the {{ strtoupper($code) }} version only. The other language is untouched.
                        </small>
                    </div>
                </form>

            </div>
        @endforeach
    </div>
</fieldset>

@push('scripts')
<script>
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: 'textarea.tinymce-content',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks | bold italic underline | link image media | numlist bullist | removeformat',
        });
    }
</script>
@endpush
