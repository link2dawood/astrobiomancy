<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    const SUPPORTED = ['en', 'de'];
    const DEFAULT   = 'en';
    const COOKIE    = 'site_locale';

    public function handle($request, Closure $next)
    {
        // Cookie-overrides-URL: when a returning visitor lands on a locale-prefixed
        // URL that disagrees with their saved language, silently redirect to the
        // equivalent path under their preferred locale. Only applies to GET so
        // POST bodies (form submissions, etc.) are never lost to a 302.
        if ($request->isMethod('GET')) {
            $urlSegment = $request->segment(1);
            $cookie     = $request->cookie(self::COOKIE);
            if (
                in_array($urlSegment, self::SUPPORTED, true)
                && in_array($cookie, self::SUPPORTED, true)
                && $cookie !== $urlSegment
            ) {
                $path = $request->path();
                $newPath = preg_replace('#^' . $urlSegment . '#', $cookie, $path, 1);
                $query = $request->getQueryString();
                $target = '/' . $newPath . ($query ? '?' . $query : '');
                return redirect($target, 302);
            }
        }

        $locale = $this->resolve($request);

        App::setLocale($locale);
        view()->share('locale', $locale);
        view()->share('supportedLocales', self::SUPPORTED);

        // Drop the {locale} route parameter so controller signatures stay clean
        // and url generation can default it from app locale.
        if ($request->route() && $request->route()->hasParameter('locale')) {
            $request->route()->forgetParameter('locale');
        }
        \Illuminate\Support\Facades\URL::defaults(['locale' => $locale]);

        $response = $next($request);

        if ($request->cookie(self::COOKIE) !== $locale && method_exists($response, 'cookie')) {
            $response->cookie(self::COOKIE, $locale, 60 * 24 * 365);
        }

        return $response;
    }

    private function resolve($request)
    {
        $segment = $request->segment(1);
        if (in_array($segment, self::SUPPORTED, true)) {
            return $segment;
        }

        $cookie = $request->cookie(self::COOKIE);
        if (in_array($cookie, self::SUPPORTED, true)) {
            return $cookie;
        }

        $accept = strtolower(substr((string) $request->header('Accept-Language'), 0, 2));
        if (in_array($accept, self::SUPPORTED, true)) {
            return $accept;
        }

        return self::DEFAULT;
    }
}
