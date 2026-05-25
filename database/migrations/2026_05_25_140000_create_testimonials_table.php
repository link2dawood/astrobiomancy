<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    /**
     * One row per (testimonial, language). Editors create an EN row and a DE row
     * for the same person, optionally linked via translation_of (mirrors blog/pages).
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $t) {
            $t->bigIncrements('id');
            $t->string('lang', 5)->default('en')->index();
            $t->string('name', 191);
            $t->text('content');
            $t->string('photo', 255)->nullable();
            $t->date('display_date')->nullable();
            $t->unsignedInteger('sort')->default(0);
            $t->string('status', 32)->default('Published')->index();
            $t->unsignedBigInteger('translation_of')->nullable()->index();
            $t->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
}
