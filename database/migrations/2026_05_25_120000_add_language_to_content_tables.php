<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageToContentTables extends Migration
{
    /**
     * Tables that carry translatable content. Each gets a `lang` column
     * (ISO 639-1, two letters). Existing rows are stamped 'en' so the
     * default site keeps working; DE copies are created by editors.
     *
     * Singletons (homepage, about_us, etc.) end up with one row per language.
     * Collections (blog, pages, services_page) end up with N rows per language.
     */
    private $tables = [
        'blog',
        'pages',
        'services_page',
        'categories',
        'comments',
        'homepage',
        'about_us',
        'privacypolicy',
        'disclaimer',
        'settings',
    ];

    public function up()
    {
        foreach ($this->tables as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }
            if (Schema::hasColumn($table, 'lang')) {
                continue;
            }
            Schema::table($table, function (Blueprint $t) use ($table) {
                $t->string('lang', 5)->default('en')->after('id')->index();
            });
        }

        if (!Schema::hasTable('menu_items')) {
            Schema::create('menu_items', function (Blueprint $t) {
                $t->bigIncrements('id');
                $t->string('lang', 5)->index();
                $t->string('location', 32);
                $t->string('label');
                $t->string('url');
                $t->unsignedInteger('sort')->default(0);
                $t->timestamps();
            });
        }
    }

    public function down()
    {
        foreach ($this->tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'lang')) {
                Schema::table($table, function (Blueprint $t) {
                    $t->dropColumn('lang');
                });
            }
        }
        Schema::dropIfExists('menu_items');
    }
}
