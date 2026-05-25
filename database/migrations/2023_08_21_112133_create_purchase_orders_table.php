<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
             $table->id();
             $table->String('expected_delivery_date')->nullable();
             $table->String('location')->nullable();
             $table->String('purchase_order_items')->nullable();
             $table->String('supplier')->nullable();
             $table->String('fully_received')->nullable();
             $table->String('status')->nullable();
             $table->String('user_id')->nullable();
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            //
        });
    }
}
