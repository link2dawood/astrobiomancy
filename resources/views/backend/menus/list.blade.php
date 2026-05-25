@section('title', 'Menus')
@include('backend.includes.head')
<body class="theme-template-dark theme-pink">
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
                                <legend>Navigation menus</legend>

                                <div class="d-flex align-items-center justify-content-between" style="margin-bottom: 16px;">
                                    <ul class="nav nav-tabs">
                                        @foreach ($locales as $loc)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $lang === $loc ? 'active' : '' }}"
                                                   href="{{ url('dashboard/menus?lang=' . $loc) }}">{{ strtoupper($loc) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ url('dashboard/menus/add?lang=' . $lang) }}" class="btn btn-sm btn-primary">+ New menu item</a>
                                </div>

                                @foreach ($locations as $locCode => $locLabel)
                                    <h5 style="margin-top: 24px;">{{ $locLabel }}</h5>
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th style="width: 60px;">Sort</th>
                                                <th>Label</th>
                                                <th>URL</th>
                                                <th style="width: 130px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse (($items[$locCode] ?? []) as $i)
                                                <tr>
                                                    <td>{{ $i->sort }}</td>
                                                    <td>{{ $i->label }}</td>
                                                    <td><code>{{ $i->url }}</code></td>
                                                    <td>
                                                        <a href="{{ url('dashboard/menus/edit/' . $i->id) }}" class="btn btn-xs btn-info">Edit</a>
                                                        <a href="{{ url('dashboard/menus/delete/' . $i->id) }}"
                                                           class="btn btn-xs btn-danger"
                                                           onclick="return confirm('Delete this menu item?');">Delete</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr><td colspan="4" class="text-muted">No items yet for this location.</td></tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                @endforeach

                                <p class="text-muted small" style="margin-top: 24px;">
                                    When at least one item exists for a location + language, the public site renders
                                    those items instead of the hardcoded defaults. To revert to the defaults, delete
                                    all items for that location + language.
                                </p>
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
