<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddSlugToSingletonPages extends Migration
{
    /**
     * Each singleton page (about, disclaimer, privacy) gets an editable
     * `slug` column. Defaults to the original hardcoded URL value so
     * existing links keep working until an editor renames it.
     */
    private $defaults = [
        'about_us'      => 'about-us',
        'disclaimer'    => 'disclaimer',
        'privacypolicy' => 'privacy-policy',
    ];

    public function up()
    {
        foreach ($this->defaults as $table => $default) {
            if (!Schema::hasTable($table)) continue;

            if (!Schema::hasColumn($table, 'slug')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->string('slug', 191)->nullable()->index();
                });
            }

            // Backfill any existing rows with the default slug if empty.
            DB::table($table)
                ->whereNull('slug')
                ->orWhere('slug', '')
                ->update(['slug' => $default]);
        }
    }

    public function down()
    {
        foreach (array_keys($this->defaults) as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'slug')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropColumn('slug');
                });
            }
        }
    }
}
