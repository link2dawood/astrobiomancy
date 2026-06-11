<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddStatusToServices extends Migration
{
    /**
     * Adds a per-row status flag to services_page so editors can take a
     * service offline without deleting it. Defaults to 'Published';
     * existing rows keep working unchanged.
     *
     * Admin toggles every language row of the same slug at once, so in
     * practice status applies to the whole service rather than just one
     * language version.
     */
    public function up()
    {
        if (!Schema::hasTable('services_page')) {
            return;
        }

        if (!Schema::hasColumn('services_page', 'status')) {
            Schema::table('services_page', function (Blueprint $t) {
                $t->string('status', 32)->default('Published')->index();
            });
        }

        DB::table('services_page')->whereNull('status')->orWhere('status', '')->update(['status' => 'Published']);
    }

    public function down()
    {
        if (Schema::hasTable('services_page') && Schema::hasColumn('services_page', 'status')) {
            Schema::table('services_page', function (Blueprint $t) {
                $t->dropColumn('status');
            });
        }
    }
}
