<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
           $table->id();
           $table->String('item')->nullable();
           $table->String('item_brand')->nullable();
           $table->String('item_brand_received')->nullable();
           $table->String('qty')->nullable();
           $table->String('qty_received')->nullable();
           $table->String('lot_number')->nullable();
           $table->String('po_id')->nullable();
           $table->String('newbrand')->nullable();
           $table->String('is_approved')->nullable();
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
        Schema::table('purchase_order_items', function (Blueprint $table) {
            //
        });
    }
}
