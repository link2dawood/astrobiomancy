@section('title', 'Testimonials')
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
                                <legend>Testimonials</legend>

                                <div class="d-flex align-items-center justify-content-between" style="margin-bottom: 16px;">
                                    <ul class="nav nav-tabs">
                                        @foreach ($locales as $loc)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $lang === $loc ? 'active' : '' }}"
                                                   href="{{ url('dashboard/testimonials?lang=' . $loc) }}">{{ strtoupper($loc) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ url('dashboard/testimonials/add?lang=' . $lang) }}" class="btn btn-sm btn-primary">+ New testimonial</a>
                                </div>

                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">Sort</th>
                                            <th style="width:70px;">Photo</th>
                                            <th>Name</th>
                                            <th>Excerpt</th>
                                            <th style="width:110px;">Date</th>
                                            <th style="width:90px;">Status</th>
                                            <th style="width:130px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($items as $t)
                                            <tr>
                                                <td>{{ $t->sort }}</td>
                                                <td>
                                                    @if ($t->photo)
                                                        <img src="{{ url('public/uploads/testimonials/' . $t->photo) }}"
                                                             alt="" style="width:48px;height:48px;border-radius:50%;object-fit:cover;">
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>
                                                <td>{{ $t->name }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit(trim(strip_tags($t->content)), 80) }}</td>
                                                <td>{{ optional($t->display_date)->format('Y-m-d') ?? '—' }}</td>
                                                <td>
                                                    <span class="badge {{ $t->status === 'Published' ? 'badge-success' : 'badge-warning' }}">
                                                        {{ $t->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ url('dashboard/testimonials/edit/' . $t->id) }}" class="btn btn-xs btn-info">Edit</a>
                                                    <a href="{{ url('dashboard/testimonials/delete/' . $t->id) }}"
                                                       class="btn btn-xs btn-danger"
                                                       onclick="return confirm('Delete this testimonial?');">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="7" class="text-muted">No testimonials yet for {{ strtoupper($lang) }}.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div style="margin-top: 16px;">{{ $items->appends(['lang' => $lang])->links() }}</div>
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
