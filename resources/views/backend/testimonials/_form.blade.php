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
    <div class="col-md-6">
        <label class="control-label">Name</label>
        <input type="text" name="name" class="form-control" required value="{{ $item->name ?? '' }}">
    </div>
    <div class="col-md-3">
        <label class="control-label">Status</label>
        <select class="form-control" name="status" required>
            @foreach (['Published', 'Pending'] as $s)
                <option value="{{ $s }}" {{ ($item->status ?? 'Published') === $s ? 'selected' : '' }}>{{ $s }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row" style="margin-top: 15px;">
    <div class="col-md-12">
        <label class="control-label">Testimonial</label>
        <textarea name="content" rows="6" class="form-control" required>{{ $item->content ?? '' }}</textarea>
    </div>
</div>

<div class="row" style="margin-top: 15px;">
    <div class="col-md-4">
        <label class="control-label">Display date</label>
        <input type="date" name="display_date" class="form-control"
               value="{{ optional($item->display_date ?? null)->format('Y-m-d') }}">
    </div>
    <div class="col-md-2">
        <label class="control-label">Sort</label>
        <input type="number" name="sort" class="form-control" value="{{ $item->sort ?? 0 }}">
    </div>
    <div class="col-md-6">
        <label class="control-label">Photo (optional)</label>
        <input type="file" name="photo" class="form-control" accept="image/*">
        @if (!empty($item->photo))
            <small class="text-muted">Current:
                <a href="{{ url('public/uploads/testimonials/' . $item->photo) }}" target="_blank">{{ $item->photo }}</a>
            </small>
        @endif
    </div>
</div>

<div class="row" style="margin-top: 15px;">
    <div class="col-md-6">
        <label class="control-label">Translation of</label>
        <select class="form-control" name="translation_of">
            <option value="">— None (original) —</option>
            @foreach ($parents as $p)
                <option value="{{ $p->id }}" {{ ($item->translation_of ?? null) == $p->id ? 'selected' : '' }}>
                    [{{ strtoupper($p->lang) }}] {{ $p->name }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">Link this row to its counterpart in the other language.</small>
    </div>
</div>
