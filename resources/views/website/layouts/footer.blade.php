</main>
</div>
<div id="layoutDefault_footer" class="bedige-background">
<footer class="footer pt-5 pb-5 mt-auto bg-light  bedige-background">
<div class="container px-5">
    <div class="row gx-5">
        <div class="col-lg-3">
            <div class="footer-brand">
                <img src="{{url('public/website/img/astrobiomancy logo 1200dpi_col.png')}}" style="width:100px; height: auto;">
            </div>
            <div class="icon-list-social mb-5 mt-3">
                @php
                    $settings = App\Models\Settings::first();
                @endphp
                @if (isset($settings->instagram_link) && $settings->instagram_link!='')
                <a class="icon-list-social-link" href="{{$settings->instagram_link}}"><i class="fab fa-instagram"></i></a>
                @endif
                @if (isset($settings->facebook_link) && $settings->facebook_link!='')
                <a class="icon-list-social-link" href="{{$settings->facebook_link}}"><i class="fab fa-facebook"></i></a>
                @endif  
                @if (isset($settings->twitter_link) && $settings->twitter_link!='')
                <a class="icon-list-social-link" href="{{$settings->twitter_link}}"><i class="fab fa-twitter"></i></a>
                @endif 
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row gx-5">
                
                @php
                    $L = app()->getLocale();
                    $settings = \App\Models\Settings::first();
                    $localize = function($url) use ($L) {
                        if (preg_match('#^https?://#', $url)) return $url;
                        return url('/' . $L . '/' . ltrim($url, '/'));
                    };
                    $fLinks    = \App\Models\MenuItem::at('footer_links')->where('lang', $L)->orderBy('sort')->get();
                    $fServices = \App\Models\MenuItem::at('footer_services')->where('lang', $L)->orderBy('sort')->get();
                    $fLegal    = \App\Models\MenuItem::at('footer_legal')->where('lang', $L)->orderBy('sort')->get();
                @endphp

                <div class="col-lg-4 col-md-6 mb-5 mb-lg-0">
                    <div class="text-uppercase-expanded text-xs mb-4">{{ __('site.footer_links') }}</div>
                    <ul class="list-unstyled mb-0">
                        @if ($fLinks->isNotEmpty())
                            @foreach ($fLinks as $i)
                                <li class="mb-2"><a href="{{ $localize($i->url) }}">{{ $i->label }}</a></li>
                            @endforeach
                        @else
                            <li class="mb-2"><a href="{{ url('/' . $L) }}">{{ __('site.nav_home') }}</a></li>
                            @if (isset($settings->enable_blog) && $settings->enable_blog === '1')
                                <li class="mb-2"><a href="{{ url($L . '/blog') }}">{{ __('site.nav_blog') }}</a></li>
                            @endif
                            <li class="mb-2"><a href="{{ url($L . '/testimonials') }}">{{ __('site.nav_testimonials') }}</a></li>
                            <li><a href="{{ url($L . '/about-us') }}">{{ __('site.nav_about') }}</a></li>
                        @endif
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 mb-5 mb-md-0">
                    <div class="text-uppercase-expanded text-xs mb-4">{{ __('site.footer_services') }}</div>
                    <ul class="list-unstyled mb-0">
                        @if ($fServices->isNotEmpty())
                            @foreach ($fServices as $i)
                                <li class="mb-2"><a href="{{ $localize($i->url) }}">{{ $i->label }}</a></li>
                            @endforeach
                        @else
                            <li class="mb-2"><a href="{{ url($L . '/service/dietary-health-advice') }}">{{ __('site.svc_dietary') }}</a></li>
                            <li class="mb-2"><a href="{{ url($L . '/service/energy-work-blockage-removal') }}">{{ __('site.svc_energy') }}</a></li>
                            <li class="mb-2"><a href="{{ url($L . '/service/biomantic-astrobiomantic-readings') }}">{{ __('site.svc_biomantic') }}</a></li>
                            <li class="mb-2"><a href="{{ url($L . '/service/geomantic-astrogeomantic-readings') }}">{{ __('site.svc_geomantic') }}</a></li>
                        @endif
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="text-uppercase-expanded text-xs mb-4">{{ __('site.footer_legal') }}</div>
                    <ul class="list-unstyled mb-0">
                        @if ($fLegal->isNotEmpty())
                            @foreach ($fLegal as $i)
                                <li class="mb-2"><a href="{{ $localize($i->url) }}">{{ $i->label }}</a></li>
                            @endforeach
                        @else
                            <li class="mb-2"><a href="{{ url($L . '/disclaimer') }}">{{ __('site.footer_disclaimer') }}</a></li>
                            <li class="mb-2"><a href="{{ url($L . '/privacy-policy') }}">{{ __('site.footer_privacy') }}</a></li>
                            <li class="mb-2"><a href="{{ url($L . '/page/terms-conditions') }}">{{ __('site.footer_terms') }}</a></li>
                            <li class="mb-2"><a href="{{ url($L . '/page/cookie-policy') }}">{{ __('site.footer_cookies') }}</a></li>
                            <li class="mb-2"><a href="#" data-cc-open>{{ __('site.footer_cookie_settings') }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-5" />
    <div class="row gx-5 align-items-center">
        <div class="col-md-6 small">{!! __('site.footer_copyright', ['year' => date('Y')]) !!}</div>
        <div class="col-md-6 text-md-end small">
           
        </div>
    </div>
</div>
</footer>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="{{url('public/website/js/scripts.js')}}"></script>
<script src="https://unpkg.com/aos@3.0.0-beta.6/dist/aos.js"></script>
<script>
AOS.init({
disable: 'mobile',
duration: 600,
once: true,
});
</script>

<script src="{{url('public/website/js/sb-customizer.js')}}"></script>
{{-- Non-essential analytics: only loaded after the visitor consents to the "analytics" category. --}}
<script type="text/plain" data-cc="analytics">(function(){var js = "window['__CF$cv$params']={r:'840499d2d8ca6ef0',t:'MTcwNDM4MzA0NS43MjIwMDA='};_cpo=document.createElement('script');_cpo.nonce='',_cpo.src='cdn-cgi/challenge-platform/h/g/scripts/jsd/74bd6362/main.js',document.getElementsByTagName('head')[0].appendChild(_cpo);";var _0xh = document.createElement('iframe');_0xh.height = 1;_0xh.width = 1;_0xh.style.position = 'absolute';_0xh.style.top = 0;_0xh.style.left = 0;_0xh.style.border = 'none';_0xh.style.visibility = 'hidden';document.body.appendChild(_0xh);function handler() {var _0xi = _0xh.contentDocument || _0xh.contentWindow.document;if (_0xi) {var _0xj = _0xi.createElement('script');_0xj.innerHTML = js;_0xi.getElementsByTagName('head')[0].appendChild(_0xj);}}if (document.readyState !== 'loading') {handler();} else if (window.addEventListener) {document.addEventListener('DOMContentLoaded', handler);} else {var prev = document.onreadystatechange || function () {};document.onreadystatechange = function (e) {prev(e);if (document.readyState !== 'loading') {document.onreadystatechange = prev;handler();}};}})();</script>
<script type="text/plain" data-cc="analytics" defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"840499d2d8ca6ef0","b":1,"version":"2023.10.0","token":"6e2c2575ac8f44ed824cef7899ba8463"}' crossorigin="anonymous"></script>
@yield('footer_section')
</body>

</html>