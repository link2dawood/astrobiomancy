<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SeedCookiePolicyPages extends Migration
{
    /**
     * Seeds default Cookie Policy rows in `pages` for EN and DE so the route
     * /{locale}/page/cookie-policy works immediately. Idempotent: only inserts
     * when the (slug, lang) pair is missing. Editors can refine the content
     * via the admin pages editor afterwards.
     */
    public function up()
    {
        if (!Schema::hasTable('pages')) {
            return;
        }

        $seed = [
            'en' => [
                'main_heading'   => 'Cookie Policy',
                'second_heading' => 'How we use cookies on this website',
                'description'    => $this->bodyEn(),
                'meta_title'     => 'Cookie Policy | Astrobiomancy',
                'meta_description' => 'How Astrobiomancy uses cookies, which categories are used, and how to manage your consent.',
            ],
            'de' => [
                'main_heading'   => 'Cookie-Richtlinie',
                'second_heading' => 'Wie wir Cookies auf dieser Website verwenden',
                'description'    => $this->bodyDe(),
                'meta_title'     => 'Cookie-Richtlinie | Astrobiomancy',
                'meta_description' => 'Wie Astrobiomancy Cookies verwendet, welche Kategorien eingesetzt werden und wie Sie Ihre Einwilligung verwalten.',
            ],
        ];

        $hasLang = Schema::hasColumn('pages', 'lang');
        $hasMeta = Schema::hasColumn('pages', 'meta_title');

        foreach ($seed as $lang => $row) {
            $query = DB::table('pages')->where('slug', 'cookie-policy');
            if ($hasLang) {
                $query->where('lang', $lang);
            }
            if ($query->exists()) {
                continue;
            }

            $insert = [
                'slug'           => 'cookie-policy',
                'main_heading'   => $row['main_heading'],
                'second_heading' => $row['second_heading'],
                'description'    => $row['description'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
            if ($hasLang) {
                $insert['lang'] = $lang;
            }
            if ($hasMeta) {
                $insert['meta_title']       = $row['meta_title'];
                $insert['meta_description'] = $row['meta_description'];
            }

            DB::table('pages')->insert($insert);
        }
    }

    public function down()
    {
        if (Schema::hasTable('pages')) {
            DB::table('pages')->where('slug', 'cookie-policy')->delete();
        }
    }

    private function bodyEn()
    {
        return <<<'HTML'
<h3>What are cookies?</h3>
<p>Cookies are small text files placed on your device when you visit a website. They are used to remember preferences, keep you signed in, and — where you have consented — to measure usage so we can improve the site.</p>

<h3>Categories we use</h3>
<h4>Strictly necessary</h4>
<p>These cookies are required for the site to function. They handle session management, authentication, CSRF protection, and remembering your cookie-consent choice itself. They cannot be disabled.</p>
<ul>
    <li><strong>laravel_session</strong> — session identifier, expires when the browser is closed or after 120 minutes of inactivity.</li>
    <li><strong>XSRF-TOKEN</strong> — anti-CSRF token used by form submissions.</li>
    <li><strong>site_locale</strong> — remembers your chosen language (EN/DE). Expires after 1 year.</li>
    <li><strong>cookie_consent</strong> — stores your choices on this banner. Expires after 1 year.</li>
</ul>

<h4>Analytics</h4>
<p>If you allow analytics, we load Cloudflare's anonymous performance beacon. It collects aggregate metrics such as page load time and country-level traffic. No data is sold or shared with third parties for marketing purposes.</p>

<h4>Marketing</h4>
<p>Currently inactive on this site. If we add marketing cookies in the future, they will only run after you have given consent in this banner.</p>

<h3>Managing your choice</h3>
<p>You can change your preferences at any time using the <em>Cookie settings</em> link in the footer. Rejecting non-essential cookies will not affect access to the site.</p>

<h3>Contact</h3>
<p>Questions about this policy? Reach us at <a href="mailto:contact@astrobiomancy.com">contact@astrobiomancy.com</a>.</p>
HTML;
    }

    private function bodyDe()
    {
        return <<<'HTML'
<h3>Was sind Cookies?</h3>
<p>Cookies sind kleine Textdateien, die auf Ihrem Gerät gespeichert werden, wenn Sie eine Website besuchen. Sie speichern Einstellungen, halten Sie angemeldet und – sofern Sie eingewilligt haben – messen die Nutzung, damit wir die Seite verbessern können.</p>

<h3>Kategorien, die wir verwenden</h3>
<h4>Unbedingt erforderlich</h4>
<p>Diese Cookies sind für den Betrieb der Seite erforderlich. Sie verwalten Sitzungen, Anmeldung, CSRF-Schutz und speichern Ihre Cookie-Einwilligung selbst. Sie können nicht deaktiviert werden.</p>
<ul>
    <li><strong>laravel_session</strong> — Sitzungs-ID, läuft beim Schließen des Browsers bzw. nach 120 Minuten Inaktivität ab.</li>
    <li><strong>XSRF-TOKEN</strong> — Anti-CSRF-Token für Formularübermittlungen.</li>
    <li><strong>site_locale</strong> — speichert Ihre gewählte Sprache (EN/DE). Gültigkeit: 1 Jahr.</li>
    <li><strong>cookie_consent</strong> — speichert Ihre Auswahl in diesem Banner. Gültigkeit: 1 Jahr.</li>
</ul>

<h4>Analyse</h4>
<p>Wenn Sie die Analyse erlauben, laden wir den anonymen Performance-Beacon von Cloudflare. Er erfasst aggregierte Kennzahlen wie Ladezeiten und Länder-Traffic. Es werden keine Daten an Dritte zu Marketingzwecken verkauft oder weitergegeben.</p>

<h4>Marketing</h4>
<p>Derzeit auf dieser Seite nicht aktiv. Sollten wir künftig Marketing-Cookies einsetzen, werden diese ausschließlich nach Ihrer Einwilligung in diesem Banner ausgeführt.</p>

<h3>Auswahl verwalten</h3>
<p>Sie können Ihre Einstellungen jederzeit über den Link <em>Cookie-Einstellungen</em> im Footer ändern. Das Ablehnen nicht erforderlicher Cookies schränkt die Nutzung der Seite nicht ein.</p>

<h3>Kontakt</h3>
<p>Fragen zu dieser Richtlinie? Schreiben Sie an <a href="mailto:contact@astrobiomancy.com">contact@astrobiomancy.com</a>.</p>
HTML;
    }
}
