@section('title', 'Pages')
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
                @if(session()->has('error'))
                    <div class="alert alert-danger">{{ session()->get('error') }}</div>
                @endif

                {{-- Custom pages (Pages collection) --}}
                <div class="row m-b-40">
                    <div class="col-md-12">
                        <div class="well white">
                            <fieldset>
                                <div class="d-flex align-items-center justify-content-between" style="margin-bottom:16px;">
                                    <legend style="margin-bottom:0;">Custom pages</legend>
                                    <a href="{{ url('dashboard/pages-new') }}" class="btn btn-sm btn-primary">+ New page</a>
                                </div>

                                <p class="text-muted">
                                    Pages stored in the <code>pages</code> table. EN and DE versions of the same page
                                    are grouped together below (via their translation link) even when they have different
                                    URL slugs per language.
                                </p>

                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Language</th>
                                            <th>URL slug</th>
                                            <th>Heading</th>
                                            <th style="width: 280px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pageGroups as $key => $rows)
                                            @foreach ($rows as $i => $p)
                                                <tr {{ $i === 0 ? 'style=border-top:2px-solid-#eee;' : '' }}>
                                                    <td><span class="badge badge-info">{{ strtoupper($p->lang ?? '?') }}</span></td>
                                                    <td><code>{{ $p->slug }}</code></td>
                                                    <td>{{ $p->main_heading ?: '(no heading)' }}</td>
                                                    <td>
                                                        <a href="{{ url('dashboard/pages/' . $p->slug) }}" class="btn btn-xs btn-info">Edit</a>
                                                        @if ($loop->first)
                                                            <a href="{{ url('dashboard/pages-duplicate/' . $p->slug) }}" class="btn btn-xs btn-secondary"
                                                               onclick="return confirm('Duplicate \'{{ $p->slug }}\' into a new page?');">Duplicate</a>
                                                        @endif
                                                        <a href="{{ url('dashboard/pages-delete-row/' . $p->id) }}" class="btn btn-xs btn-danger"
                                                           onclick="return confirm('Delete just this {{ strtoupper($p->lang) }} row? The other language is kept.');">Delete row</a>
                                                        @if ($loop->first && count($rows) > 1)
                                                            <a href="{{ url('dashboard/pages-delete/' . $p->slug) }}" class="btn btn-xs btn-danger"
                                                               onclick="return confirm('Delete ALL language versions of this page?');">Delete all</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @empty
                                            <tr><td colspan="4" class="text-muted">No custom pages yet. Click <em>+ New page</em>.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </fieldset>
                        </div>
                    </div>
                </div>

                {{-- Services --}}
                <div class="row m-b-40">
                    <div class="col-md-12">
                        <div class="well white">
                            <fieldset>
                                <legend>Services</legend>
                                <p class="text-muted">
                                    Service pages (the ones with packages/pricing). To add a new service,
                                    duplicate an existing one and then change the URL slug + content.
                                </p>

                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>URL slug</th>
                                            <th>Languages</th>
                                            <th>EN Heading</th>
                                            <th style="width: 280px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($services as $slug => $rows)
                                            @php
                                                $en  = $rows->firstWhere('lang', 'en');
                                                $any = $rows->first();
                                            @endphp
                                            <tr>
                                                <td><code>{{ $slug }}</code></td>
                                                <td>
                                                    @foreach ($rows as $r)
                                                        <span class="badge badge-info">{{ strtoupper($r->lang) }}</span>
                                                    @endforeach
                                                </td>
                                                <td>{{ optional($en ?? $any)->main_heading }}</td>
                                                <td>
                                                    <a href="{{ url('dashboard/services/' . $slug) }}" class="btn btn-xs btn-info">Edit</a>
                                                    <a href="{{ url('dashboard/services-duplicate/' . $slug) }}" class="btn btn-xs btn-secondary"
                                                       onclick="return confirm('Duplicate service \'{{ $slug }}\' into a new one? You can rename the URL afterwards.');">Duplicate</a>
                                                    <a href="{{ url('dashboard/services-delete/' . $slug) }}" class="btn btn-xs btn-danger"
                                                       onclick="return confirm('Delete ALL language versions of \'{{ $slug }}\'?');">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-muted">No services found.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
