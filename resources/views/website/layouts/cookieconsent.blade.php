{{--
    GDPR-style cookie consent.

    - Renders a fixed-bottom banner (Accept all / Reject all / Customize).
    - "Customize" opens a modal with category switches:
        necessary  (always on, cannot be disabled)
        analytics
        marketing
    - Choices stored in a year-long cookie `cookie_consent` as JSON:
        {"v":1,"necessary":true,"analytics":true,"marketing":false}
    - Banner is hidden once a valid cookie is present (no nag).
    - Footer link "Cookie settings" re-opens the modal so users can change.

    To gate a third-party script:

        <script type="text/plain" data-cc="analytics" src="..."></script>

    The runtime swaps `type` to text/javascript only for categories the user
    has consented to, then re-executes the tag (for inline scripts) or sets
    src (for external).
--}}

<style>
    #ccBanner {
        position: fixed; left: 0; right: 0; bottom: 0; z-index: 2100;
        background: #5e000b; color: #fff; padding: 1rem 1.25rem;
        box-shadow: 0 -2px 8px rgba(0,0,0,.25);
        display: none;
    }
    #ccBanner.show { display: block; }
    #ccBanner .cc-inner {
        max-width: 1100px; margin: 0 auto;
        display: flex; flex-wrap: wrap; gap: 1rem; align-items: center; justify-content: space-between;
    }
    #ccBanner .cc-text { flex: 1 1 320px; font-size: .92rem; line-height: 1.45; }
    #ccBanner .cc-text a { color: #ffd28b; text-decoration: underline; }
    #ccBanner .cc-actions { display: flex; gap: .5rem; flex-wrap: wrap; }
    #ccBanner button {
        border: 0; padding: .55rem 1rem; border-radius: 4px; font-weight: 600;
        cursor: pointer; font-size: .9rem;
    }
    #ccBanner .cc-accept   { background: #ff9536; color: #fff; }
    #ccBanner .cc-reject   { background: transparent; color: #fff; border: 1px solid #fff; }
    #ccBanner .cc-customize{ background: #fff; color: #5e000b; }

    #ccModal {
        position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 2200;
        display: none; align-items: center; justify-content: center; padding: 1rem;
    }
    #ccModal.show { display: flex; }
    #ccModal .cc-box {
        background: #fff; max-width: 560px; width: 100%; border-radius: 8px;
        padding: 1.75rem; box-shadow: 0 10px 30px rgba(0,0,0,.25);
        max-height: 90vh; overflow-y: auto;
    }
    #ccModal h3 { color: #5e000b; margin-top: 0; }
    #ccModal .cc-row {
        display: flex; justify-content: space-between; gap: 1rem;
        padding: .85rem 0; border-bottom: 1px solid #f0e7d6;
    }
    #ccModal .cc-row:last-of-type { border-bottom: 0; }
    #ccModal .cc-row strong { color: #5e000b; }
    #ccModal .cc-row p { font-size: .85rem; margin: .25rem 0 0; color: #555; }
    #ccModal .cc-toggle { white-space: nowrap; }
    #ccModal .cc-toggle input { transform: scale(1.2); margin-right: .35rem; }
    #ccModal .cc-foot {
        display: flex; gap: .5rem; justify-content: flex-end; margin-top: 1.25rem; flex-wrap: wrap;
    }
    #ccModal .cc-foot button {
        border: 0; padding: .55rem 1rem; border-radius: 4px; font-weight: 600; cursor: pointer; font-size: .9rem;
    }
    #ccModal .cc-foot .cc-save     { background: #ff9536; color: #fff; }
    #ccModal .cc-foot .cc-accept   { background: #c9cb47; color: #5e000b; }
    #ccModal .cc-foot .cc-reject   { background: #fff; color: #5e000b; border: 1px solid #5e000b; }
</style>

@php $L = app()->getLocale(); @endphp

<div id="ccBanner" role="dialog" aria-live="polite" aria-label="{{ __('site.cc_banner_title') }}">
    <div class="cc-inner">
        <div class="cc-text">
            <strong>{{ __('site.cc_banner_title') }}</strong><br>
            {{ __('site.cc_banner_body') }}
            <a href="{{ url($L . '/page/cookie-policy') }}">{{ __('site.cc_learn_more') }}</a>
        </div>
        <div class="cc-actions">
            <button type="button" class="cc-reject"    data-cc-act="reject">{{ __('site.cc_reject') }}</button>
            <button type="button" class="cc-customize" data-cc-act="customize">{{ __('site.cc_customize') }}</button>
            <button type="button" class="cc-accept"    data-cc-act="accept">{{ __('site.cc_accept') }}</button>
        </div>
    </div>
</div>

<div id="ccModal" role="dialog" aria-modal="true" aria-labelledby="ccModalTitle">
    <div class="cc-box">
        <h3 id="ccModalTitle">{{ __('site.cc_modal_title') }}</h3>
        <p>{{ __('site.cc_modal_intro') }}</p>

        <div class="cc-row">
            <div>
                <strong>{{ __('site.cc_cat_necessary') }}</strong>
                <p>{{ __('site.cc_cat_necessary_desc') }}</p>
            </div>
            <label class="cc-toggle">
                <input type="checkbox" checked disabled> {{ __('site.cc_always_on') }}
            </label>
        </div>

        <div class="cc-row">
            <div>
                <strong>{{ __('site.cc_cat_analytics') }}</strong>
                <p>{{ __('site.cc_cat_analytics_desc') }}</p>
            </div>
            <label class="cc-toggle">
                <input type="checkbox" id="ccCatAnalytics"> {{ __('site.cc_enable') }}
            </label>
        </div>

        <div class="cc-row">
            <div>
                <strong>{{ __('site.cc_cat_marketing') }}</strong>
                <p>{{ __('site.cc_cat_marketing_desc') }}</p>
            </div>
            <label class="cc-toggle">
                <input type="checkbox" id="ccCatMarketing"> {{ __('site.cc_enable') }}
            </label>
        </div>

        <div class="cc-foot">
            <button type="button" class="cc-reject" data-cc-act="reject">{{ __('site.cc_reject_all') }}</button>
            <button type="button" class="cc-save"   data-cc-act="save">{{ __('site.cc_save_choices') }}</button>
            <button type="button" class="cc-accept" data-cc-act="accept">{{ __('site.cc_accept_all') }}</button>
        </div>
    </div>
</div>

<script>
(function () {
    var STORAGE_VERSION = 1;
    var COOKIE_NAME = 'cookie_consent';
    var CATS = ['analytics', 'marketing']; // 'necessary' is implicit, always true

    function readCookie() {
        var match = ('; ' + document.cookie).split('; ' + COOKIE_NAME + '=');
        if (match.length < 2) return null;
        try {
            return JSON.parse(decodeURIComponent(match.pop().split(';').shift()));
        } catch (e) { return null; }
    }
    function writeCookie(value) {
        var expires = new Date();
        expires.setFullYear(expires.getFullYear() + 1);
        document.cookie = COOKIE_NAME + '=' + encodeURIComponent(JSON.stringify(value))
            + '; expires=' + expires.toUTCString()
            + '; path=/; SameSite=Lax';
    }
    function deleteCookie(name) {
        document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
    }

    function unlock(consent) {
        // Swap any <script type="text/plain" data-cc="..."> whose category was approved.
        var pending = document.querySelectorAll('script[type="text/plain"][data-cc]');
        pending.forEach(function (node) {
            var cat = node.getAttribute('data-cc');
            if (cat === 'necessary' || consent[cat]) {
                var s = document.createElement('script');
                // copy attributes
                Array.prototype.slice.call(node.attributes).forEach(function (a) {
                    if (a.name === 'type') return;
                    s.setAttribute(a.name, a.value);
                });
                s.type = 'text/javascript';
                if (!node.src) s.text = node.textContent || '';
                node.parentNode.replaceChild(s, node);
            }
        });

        // Best-effort cleanup of common non-essential cookies when revoked.
        if (!consent.analytics) {
            ['_ga', '_gid', '_gat', '__cf_bm'].forEach(deleteCookie);
        }
        if (!consent.marketing) {
            ['_fbp', '_gcl_au'].forEach(deleteCookie);
        }
    }

    function showBanner()  { document.getElementById('ccBanner').classList.add('show'); }
    function hideBanner()  { document.getElementById('ccBanner').classList.remove('show'); }
    function openModal(consent) {
        document.getElementById('ccCatAnalytics').checked = !!(consent && consent.analytics);
        document.getElementById('ccCatMarketing').checked = !!(consent && consent.marketing);
        document.getElementById('ccModal').classList.add('show');
    }
    function closeModal()  { document.getElementById('ccModal').classList.remove('show'); }

    function persist(consent) {
        consent.v = STORAGE_VERSION;
        consent.necessary = true;
        writeCookie(consent);
        unlock(consent);
        hideBanner();
        closeModal();
        document.dispatchEvent(new CustomEvent('cookieconsent:changed', { detail: consent }));
    }

    // Public API
    window.cookieConsent = {
        get: function () { return readCookie() || { necessary: true }; },
        has: function (cat) { var c = readCookie(); return cat === 'necessary' || !!(c && c[cat]); },
        open: function () { openModal(readCookie() || {}); },
        reset: function () { deleteCookie(COOKIE_NAME); showBanner(); },
    };

    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-cc-act]');
        if (!btn) return;
        var act = btn.getAttribute('data-cc-act');
        if (act === 'accept') {
            persist({ analytics: true, marketing: true });
        } else if (act === 'reject') {
            persist({ analytics: false, marketing: false });
        } else if (act === 'customize') {
            openModal(readCookie() || {});
        } else if (act === 'save') {
            persist({
                analytics: document.getElementById('ccCatAnalytics').checked,
                marketing: document.getElementById('ccCatMarketing').checked,
            });
        } else if (act === 'close') {
            closeModal();
        }
    });

    // Re-open from anywhere via [data-cc-open]
    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-cc-open]')) {
            e.preventDefault();
            window.cookieConsent.open();
        }
    });

    // Bootstrap on load
    var existing = readCookie();
    if (existing && existing.v === STORAGE_VERSION) {
        unlock(existing);
    } else {
        showBanner();
    }
})();
</script>
