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

                <div class="row m-b-40">
                    <div class="col-md-12">
                        <div class="well white">
                            <fieldset>
                                <div class="d-flex align-items-center justify-content-between" style="margin-bottom:16px;">
                                    <legend style="margin-bottom:0;">All custom pages</legend>
                                    <a href="{{ url('dashboard/pages-new') }}" class="btn btn-sm btn-primary">+ New page</a>
                                </div>

                                <p class="text-muted">
                                    These are the pages stored in the <code>pages</code> table (typically reached via
                                    <code>/{locale}/page/{slug}</code> or via a custom slug catch-all). Each row may have
                                    EN and/or DE language versions. Click a slug to edit, or duplicate to create a new
                                    page pre-filled with the existing content.
                                </p>

                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Slug (URL)</th>
                                            <th>Languages</th>
                                            <th>EN Heading</th>
                                            <th style="width: 220px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pageGroups as $slug => $rows)
                                            @php
                                                $en  = $rows->firstWhere('lang', 'en');
                                                $de  = $rows->firstWhere('lang', 'de');
                                                $any = $rows->first();
                                            @endphp
                                            <tr>
                                                <td><code>{{ $slug }}</code></td>
                                                <td>
                                                    @if ($en)<span class="badge badge-info">EN</span>@endif
                                                    @if ($de)<span class="badge badge-info">DE</span>@endif
                                                </td>
                                                <td>{{ optional($en ?? $any)->main_heading }}</td>
                                                <td>
                                                    <a href="{{ url('dashboard/pages/' . $slug) }}" class="btn btn-xs btn-info">Edit</a>
                                                    <a href="{{ url('dashboard/pages-duplicate/' . $slug) }}" class="btn btn-xs btn-secondary"
                                                       onclick="return confirm('Duplicate \'{{ $slug }}\' into a new page?');">Duplicate</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="4" class="text-muted">No custom pages yet. Click <em>+ New page</em> to create one.</td></tr>
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
