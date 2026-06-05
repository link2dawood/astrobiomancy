<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SeedHeroPages extends Migration
{
    /**
     * Seed Pages rows for the editable hero text on the Testimonials and
     * Account pages. The public views look up these slugs and use the
     * stored heading/subheading if present.
     *
     * Idempotent — won't insert if (slug, lang) already exists.
     */
    public function up()
    {
        if (!Schema::hasTable('pages')) {
            return;
        }

        $seed = [
            'testimonials-hero' => [
                'en' => ['main_heading' => 'What people say', 'second_heading' => 'Real stories from people we have worked with.'],
                'de' => ['main_heading' => 'Was Menschen sagen', 'second_heading' => 'Echte Erfahrungen von Menschen, mit denen wir gearbeitet haben.'],
            ],
            'account-hero' => [
                'en' => ['main_heading' => 'My account', 'second_heading' => 'Update your profile, address and review your orders.'],
                'de' => ['main_heading' => 'Mein Konto', 'second_heading' => 'Profil und Adresse aktualisieren und Bestellungen einsehen.'],
            ],
        ];

        foreach ($seed as $slug => $rows) {
            foreach ($rows as $lang => $values) {
                $exists = DB::table('pages')->where('slug', $slug)->where('lang', $lang)->exists();
                if ($exists) continue;

                DB::table('pages')->insert([
                    'slug'          => $slug,
                    'lang'          => $lang,
                    'main_heading'  => $values['main_heading'],
                    'second_heading'=> $values['second_heading'],
                    'description'   => null,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('pages')) {
            DB::table('pages')
                ->whereIn('slug', ['testimonials-hero', 'account-hero'])
                ->delete();
        }
    }
}
