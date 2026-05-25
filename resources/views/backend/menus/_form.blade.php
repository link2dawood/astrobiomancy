{{--
    Shared add/edit form fields. Expects $item (may be null on add) plus $locales and $locations.
--}}
@php $item = $item ?? null; @endphp

<div class="row">
    <div class="col-md-3">
        <label class="control-label">Language</label>
        <select class="form-control" name="lang" required>
            @foreach ($locales as $loc)
                <option value="{{ $loc }}" {{ ($item->lang ?? request('lang', 'en')) === $loc ? 'selected' : '' }}>{{ strtoupper($loc) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-5">
        <label class="control-label">Location</label>
        <select class="form-control" name="location" required>
            @foreach ($locations as $code => $label)
                <option value="{{ $code }}" {{ ($item->location ?? '') === $code ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label class="control-label">Sort</label>
        <input type="number" name="sort" class="form-control" value="{{ $item->sort ?? 0 }}">
    </div>
</div>

<div class="row" style="margin-top: 15px;">
    <div class="col-md-5">
        <label class="control-label">Label</label>
        <input type="text" name="label" class="form-control" required value="{{ $item->label ?? '' }}">
    </div>
    <div class="col-md-7">
        <label class="control-label">URL</label>
        <input type="text" name="url" class="form-control" required value="{{ $item->url ?? '' }}"
               placeholder="/about-us or https://example.com">
        <small class="text-muted">Relative paths (e.g. <code>/about-us</code>) are auto-prefixed with the locale.</small>
    </div>
</div>
