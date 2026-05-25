<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaAndTranslationLink extends Migration
{
    /**
     * Per-language SEO and a translation-linking column.
     *
     * - meta_title / meta_description on every translatable content table.
     * - translation_of (nullable, self-FK by id) on `blog` and `pages` so an
     *   editor can link a DE row to its EN counterpart. Singletons don't need
     *   this — they're keyed by `lang` alone.
     */
    private $metaTargets = [
        'blog', 'pages', 'services_page',
        'homepage', 'about_us', 'privacypolicy', 'disclaimer',
    ];

    private $linkTargets = ['blog', 'pages'];

    public function up()
    {
        foreach ($this->metaTargets as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }
            Schema::table($table, function (Blueprint $t) use ($table) {
                if (!Schema::hasColumn($table, 'meta_title')) {
                    $t->string('meta_title', 191)->nullable();
                }
                if (!Schema::hasColumn($table, 'meta_description')) {
                    $t->string('meta_description', 500)->nullable();
                }
            });
        }

        foreach ($this->linkTargets as $table) {
            if (!Schema::hasTable($table) || Schema::hasColumn($table, 'translation_of')) {
                continue;
            }
            Schema::table($table, function (Blueprint $t) {
                $t->unsignedBigInteger('translation_of')->nullable()->index();
            });
        }
    }

    public function down()
    {
        foreach ($this->metaTargets as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $t) use ($table) {
                    foreach (['meta_title', 'meta_description'] as $col) {
                        if (Schema::hasColumn($table, $col)) {
                            $t->dropColumn($col);
                        }
                    }
                });
            }
        }
        foreach ($this->linkTargets as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'translation_of')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropColumn('translation_of');
                });
            }
        }
    }
}
