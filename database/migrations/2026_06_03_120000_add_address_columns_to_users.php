<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressColumnsToUsers extends Migration
{
    /**
     * Adds the eight address fields the customer fills in at signup
     * (and can edit later on the account "Address" tab).
     *
     * All nullable in the schema so existing rows aren't invalidated;
     * application-level validation enforces required-at-signup separately.
     */
    private $columns = [
        'first_name', 'last_name',
        'address', 'address2',
        'city', 'zipcode', 'state', 'country',
    ];

    public function up()
    {
        Schema::table('users', function (Blueprint $t) {
            foreach ($this->columns as $col) {
                if (!Schema::hasColumn('users', $col)) {
                    $t->string($col, 191)->nullable();
                }
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $t) {
            foreach ($this->columns as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $t->dropColumn($col);
                }
            }
        });
    }
}
