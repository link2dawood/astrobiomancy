<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;

/**
 * Locale-related public endpoints (no closures, so routes can be cached).
 */
class LocaleController extends Controller
{
    /**
     * Sets the locale cookie AND rewrites the Referer URL so the prefix
     * matches the new locale. The URL prefix is authoritative in SetLocale,
     * so just bouncing back to the Referer leaves the page rendering in the
     * old language. We swap /en/... <-> /de/... (or prepend if missing).
     */
    public function switch($switch_to)
    {
        if (!in_array($switch_to, SetLocale::SUPPORTED, true)) {
            abort(404);
        }

        $referer = request()->headers->get('referer');
        $target  = '/' . $switch_to;

        if ($referer) {
            $parts = parse_url($referer);
            $path  = $parts['path'] ?? '/';

            // Drop any existing locale prefix.
            $supported = implode('|', SetLocale::SUPPORTED);
            $stripped  = preg_replace('#^/(' . $supported . ')(?=/|$)#', '', $path);
            $stripped  = $stripped === '' ? '/' : $stripped;

            // Blog posts have per-language slugs. Looking up the translation
            // counterpart so /en/post/foo correctly becomes /de/post/{foo-de}
            // rather than the non-existent /de/post/foo.
            if (preg_match('#^/post/([^/]+)/?$#', $stripped, $m)) {
                $localized = $this->localizedBlogSlug($m[1], $switch_to);
                $stripped  = $localized ? '/post/' . $localized : '/blog';
            }

            $target = '/' . $switch_to . ($stripped === '/' ? '' : $stripped);

            if (!empty($parts['query'])) {
                $target .= '?' . $parts['query'];
            }
        }

        return redirect($target)->cookie(SetLocale::COOKIE, $switch_to, 60 * 24 * 365);
    }

    /**
     * Find the slug of the same blog post in another language. Returns null
     * if no translation exists. Walks both directions of the translation_of
     * link so it works whether the source is the original or the translation.
     */
    private function localizedBlogSlug($sourceSlug, $targetLang)
    {
        $source = \App\Models\Blog::where('slug', $sourceSlug)->first();
        if (!$source) {
            return null;
        }
        if ($source->lang === $targetLang) {
            return $source->slug;
        }

        $parentId = $source->translation_of ?: $source->id;

        $sibling = \App\Models\Blog::where('lang', $targetLang)
            ->where(function ($q) use ($parentId) {
                $q->where('id', $parentId)->orWhere('translation_of', $parentId);
            })
            ->first();

        return $sibling ? $sibling->slug : null;
    }

    /**
     * Redirects "/" to the resolved locale prefix.
     */
    public function root()
    {
        return redirect('/' . app()->getLocale());
    }

    /**
     * Standalone admin login view (the form posts to backend\LoginController@login_action).
     */
    public function adminLogin()
    {
        return view('backend.login.login');
    }

    /**
     * Fallback for any path that didn't match a registered route.
     *
     * Phase 2 moved every public page under a {locale} prefix, but old links
     * (DB content, bookmarks, legacy menus, hardcoded buttons) still point at
     * paths like /about-us. Rather than touching every view, redirect any
     * unmatched path to the locale-prefixed equivalent.
     *
     * Returns a hard 404 only when the path looks like an asset or admin URL —
     * those shouldn't be locale-prefixed.
     */
    public function fallback()
    {
        $path = request()->path();
        $first = strtok($path, '/');

        // Don't loop on admin/internal URLs that genuinely don't exist
        $reserved = ['dashboard', 'admin', 'login', 'logout', 'login_action',
                     'lang', 'cronjob', 'api', 'public', 'storage', 'uploads'];
        if (in_array($first, $reserved, true)) {
            abort(404);
        }

        // Already prefixed — really doesn't exist
        if (in_array($first, SetLocale::SUPPORTED, true)) {
            abort(404);
        }

        return redirect('/' . app()->getLocale() . '/' . $path, 301);
    }
}
