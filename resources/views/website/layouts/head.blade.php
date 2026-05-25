<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    @yield('page_meta')
    <title>Astrobiomancy | @yield('title')</title>
    <link href="{{url('public/website/css/styles.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/aos%403.0.0-beta.6/dist/aos.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script data-search-pseudo-elements="" defer="" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <style>
        .nav-orange,.navbar-scrolled {
            background-color: #ff9536 !important;
        }
        .navbar-marketing .navbar-nav .nav-item .nav-link {
            color: white !important;
        }
        .bedige-background {
            background: #feefd2 !important;
        }
        .btn-teal {
            background: #c9cb47 !important;
            opacity: 1;
            border: unset;
            color:#5e000b;
        }
        .btn-teal:hover {
            background: #60ff00;
            border: unset;
            color:#5e000b;
        }
    </style>
</head>

<body>
 <div id="layoutDefault">
    <div id="layoutDefault_content">
        <main>
        <!-- Navbar-->
        <nav class="navbar navbar-marketing navbar-expand-lg bg-transparent navbar-dark fixed-top nav-orange">
            <div class="container px-5">
                <a class="navbar-brand text-white" href="{{url('')}}">
                    <img src="{{url('public/website/img/astrobiomancy logo 1200dpi_col.png')}}" style="width:100px; height: auto;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i data-feather="menu"></i></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto me-lg-5">
                        <li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
                        
                       
                        <li class="nav-item dropdown no-caret">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownDocs" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Services
                                <i class="fas fa-chevron-right dropdown-arrow"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="navbarDropdownDocs">
                                <a class="dropdown-item py-3" href="{{url('service/dietary-health-advice')}}">
                                    Dietary & health advice
                                </a> 

                                <div class="dropdown-divider m-0"></div>
                                <a class="dropdown-item py-3" href="{{url('service/energy-work-blockage-removal')}}">
                                     Energy work & blockage removal
                                </a>
                                <div class="dropdown-divider m-0"></div>
                                <a class="dropdown-item py-3" href="{{url('service/biomantic-astrobiomantic-readings')}}">
                                     Biomantic & Astrobiomantic readings
                                </a>
                                <div class="dropdown-divider m-0"></div>
                                <a class="dropdown-item py-3" href="{{url('service/geomantic-astrogeomantic-readings')}}">
                                    Geomantic & Astrogeomantic readings
                                </a>
                            </div>
                        </li>
                        @php
                            $settings = App\Models\Settings::first();
                            if (isset($settings->enable_blog) && $settings->enable_blog==='1') {
                        @endphp
                        <li class="nav-item"><a class="nav-link" href="{{url('/blog')}}">Blog </a></li>
                        @php 
                        }
                        @endphp
                        <li class="nav-item"><a class="nav-link" href="{{url('page/about-the-book')}}">The Vibration Series </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{url('/about-us')}}">About </a></li>
                        @if(isset(Auth::user()->id))
                        <li class="nav-item dropdown no-caret">
                            <a class="nav-link dropdown-toggle" id="account" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Account
                                <i class="fas fa-chevron-right dropdown-arrow"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="account">
                                <a class="dropdown-item py-3" href="{{url('users/account')}}">
                                    Account
                                </a> 

                                <div class="dropdown-divider m-0"></div>
                                <a class="dropdown-item py-3" href="{{url('users/logout')}}">
                                    Logout
                                </a>
                                
                            </div>
                        </li>
                        @else 
                         <li class="nav-item"><a class="nav-link" href="{{url('/user/login')}}">Login </a></li>
                        @endif
                    </ul>
                    
                </div>
            </div>
        </nav>
            <!-- Page Header-->
 