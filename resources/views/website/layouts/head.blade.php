<!DOCTYPE html>
<html lang="{{ $locale ?? app()->getLocale() }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    {{-- Per-language meta. Pages can override with @section('page_meta'). --}}
    <title>@yield('title', __('site.meta_title'))</title>
    <meta name="description" content="@yield('meta_description', __('site.meta_description'))" />
    @yield('page_meta')

    {{-- hreflang: list every supported locale + x-default --}}
    @php
        $current = request()->path();
        $stripped = preg_replace('#^(en|de)(/|$)#', '', $current);
        $stripped = $stripped === '' ? '' : $stripped;
    @endphp
    @foreach (($supportedLocales ?? ['en', 'de']) as $hl)
        <link rel="alternate" hreflang="{{ $hl }}" href="{{ url('/' . $hl . ($stripped ? '/' . $stripped : '')) }}" />
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ url('/en' . ($stripped ? '/' . $stripped : '')) }}" />

    {{-- Favicon: client-uploaded 32px icon, used for every size. Browsers
         will upscale it for the high-DPI / apple-touch slots — replace
         the path here if a larger version is uploaded later. --}}
    @php $favicon = url('public/uploads/images/1780234486.png'); @endphp
    <link rel="icon" type="image/png" sizes="32x32"   href="{{ $favicon }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ $favicon }}">
    <link rel="apple-touch-icon"                      href="{{ $favicon }}">

    <link href="{{url('public/website/css/styles.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos%403.0.0-beta.6/dist/aos.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <style>
        .nav-orange,.navbar-scrolled { background-color: #ff9536 !important; }
        .navbar-marketing .navbar-nav .nav-item .nav-link { color: white !important; }
        .bedige-background { background: #feefd2 !important; }
        .btn-teal { background: #c9cb47 !important; opacity: 1; border: unset; color:#5e000b; }
        .btn-teal:hover { background: #60ff00; border: unset; color:#5e000b; }

        /* Language switcher */
        .lang-switch { display: inline-flex; gap: .25rem; align-items: center; margin-left: 1rem; }
        .lang-switch a {
            color: #fff; text-decoration: none; font-size: .8rem; padding: .15rem .45rem;
            border-radius: 3px; border: 1px solid rgba(255,255,255,.4); line-height: 1;
        }
        .lang-switch a.active { background: #fff; color: #ff9536; border-color: #fff; }

        /* First-visit popup */
        #langPickerOverlay {
            position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 2000;
            display: none; align-items: center; justify-content: center;
        }
        #langPickerOverlay.show { display: flex; }
        #langPickerOverlay .box {
            background: #fff; max-width: 420px; width: 90%; padding: 2rem; border-radius: 8px;
            text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,.2);
        }
        #langPickerOverlay h3 { margin-top: 0; color: #5e000b; }
        #langPickerOverlay .choices { display: flex; gap: 1rem; justify-content: center; margin-top: 1.5rem; }
        #langPickerOverlay .choices a {
            flex: 1; padding: .75rem 1rem; background: #ff9536; color: #fff;
            text-decoration: none; border-radius: 5px; font-weight: 600;
        }
        #langPickerOverlay .choices a:hover { background: #5e000b; }
    </style>
</head>

<body>
<div id="layoutDefault">
    <div id="layoutDefault_content">
        <main>
        <!-- Navbar-->
        <nav class="navbar navbar-marketing navbar-expand-lg bg-transparent navbar-dark fixed-top nav-orange">
            <div class="container px-5">
                <a class="navbar-brand text-white" href="{{ url('/' . app()->getLocale()) }}">
                    <img src="{{url('public/website/img/astrobiomancy logo 1200dpi_col.png')}}" style="width:100px; height: auto;" alt="{{ __('site.brand') }}">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto me-lg-5">

                        @php
                            $L = app()->getLocale();
                            $headerItems = \App\Models\MenuItem::at('header')->where('lang', $L)->orderBy('sort')->get();
                            $serviceItems = \App\Models\MenuItem::at('header_services')->where('lang', $L)->orderBy('sort')->get();
                            $settings = \App\Models\Settings::first();

                            $localize = function($url) use ($L) {
                                if (preg_match('#^https?://#', $url)) return $url;
                                return url('/' . $L . '/' . ltrim($url, '/'));
                            };
                        @endphp

                        @if ($headerItems->isNotEmpty())
                            {{-- DB-driven header items --}}
                            @foreach ($headerItems as $i)
                                <li class="nav-item"><a class="nav-link" href="{{ $localize($i->url) }}">{{ $i->label }}</a></li>
                            @endforeach

                            @if ($serviceItems->isNotEmpty())
                                <li class="nav-item dropdown no-caret">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                        {{ __('site.nav_services') }}
                                        <i class="fas fa-chevron-right dropdown-arrow"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end animated--fade-in-up">
                                        @foreach ($serviceItems as $j)
                                            <a class="dropdown-item py-3" href="{{ $localize($j->url) }}">{{ $j->label }}</a>
                                            @if (!$loop->last)<div class="dropdown-divider m-0"></div>@endif
                                        @endforeach
                                    </div>
                                </li>
                            @endif
                        @else
                            {{-- Hardcoded defaults (used until an editor populates menu_items) --}}
                            <li class="nav-item"><a class="nav-link" href="{{ url('/' . $L) }}">{{ __('site.nav_home') }}</a></li>

                            <li class="nav-item dropdown no-caret">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownDocs" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ __('site.nav_services') }}
                                    <i class="fas fa-chevron-right dropdown-arrow"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="navbarDropdownDocs">
                                    <a class="dropdown-item py-3" href="{{ url($L . '/service/dietary-health-advice') }}">{{ __('site.svc_dietary') }}</a>
                                    <div class="dropdown-divider m-0"></div>
                                    <a class="dropdown-item py-3" href="{{ url($L . '/service/energy-work-blockage-removal') }}">{{ __('site.svc_energy') }}</a>
                                    <div class="dropdown-divider m-0"></div>
                                    <a class="dropdown-item py-3" href="{{ url($L . '/service/biomantic-astrobiomantic-readings') }}">{{ __('site.svc_biomantic') }}</a>
                                    <div class="dropdown-divider m-0"></div>
                                    <a class="dropdown-item py-3" href="{{ url($L . '/service/geomantic-astrogeomantic-readings') }}">{{ __('site.svc_geomantic') }}</a>
                                </div>
                            </li>

                            @if(isset($settings->enable_blog) && $settings->enable_blog === '1')
                                <li class="nav-item"><a class="nav-link" href="{{ url($L . '/blog') }}">{{ __('site.nav_blog') }}</a></li>
                            @endif

                            <li class="nav-item"><a class="nav-link" href="{{ url($L . '/page/about-the-book') }}">{{ __('site.nav_book') }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url($L . '/testimonials') }}">{{ __('site.nav_testimonials') }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ url($L . '/about-us') }}">{{ __('site.nav_about') }}</a></li>
                        @endif

                        @if(isset(Auth::user()->id))
                            <li class="nav-item dropdown no-caret">
                                <a class="nav-link dropdown-toggle" id="account" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ __('site.nav_account') }}
                                    <i class="fas fa-chevron-right dropdown-arrow"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="account">
                                    <a class="dropdown-item py-3" href="{{ url(app()->getLocale() . '/users/account') }}">{{ __('site.nav_account') }}</a>
                                    <div class="dropdown-divider m-0"></div>
                                    <a class="dropdown-item py-3" href="{{ url(app()->getLocale() . '/users/logout') }}">{{ __('site.nav_logout') }}</a>
                                </div>
                            </li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ url(app()->getLocale() . '/user/login') }}">{{ __('site.nav_login') }}</a></li>
                        @endif

                        {{-- Persistent EN / DE switcher --}}
                        <li class="nav-item d-flex align-items-center">
                            <span class="lang-switch" role="group" aria-label="Language">
                                @foreach (($supportedLocales ?? ['en', 'de']) as $loc)
                                    <a href="{{ url('/lang/' . $loc) }}"
                                       class="{{ app()->getLocale() === $loc ? 'active' : '' }}"
                                       hreflang="{{ $loc }}"
                                       title="{{ __('site.lang_' . $loc) }}">{{ strtoupper($loc) }}</a>
                                @endforeach
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{-- First-visit language picker (cookie-gated) --}}
        <div id="langPickerOverlay" aria-modal="true" role="dialog" aria-labelledby="langPickerTitle">
            <div class="box">
                <h3 id="langPickerTitle">{{ __('site.lang_pick_title') }}</h3>
                <p>{{ __('site.lang_pick_body') }}</p>
                <div class="choices">
                    <a href="{{ url('/lang/en') }}">{{ __('site.lang_en') }}</a>
                    <a href="{{ url('/lang/de') }}">{{ __('site.lang_de') }}</a>
                </div>
            </div>
        </div>
        <script>
            (function () {
                var hasCookie = document.cookie.split('; ').some(function (c) { return c.indexOf('site_locale=') === 0; });
                var seen = localStorage.getItem('lang_picker_seen');
                if (!hasCookie && !seen) {
                    document.getElementById('langPickerOverlay').classList.add('show');
                    localStorage.setItem('lang_picker_seen', '1');
                }
            })();
        </script>
        <!-- Page Header-->
