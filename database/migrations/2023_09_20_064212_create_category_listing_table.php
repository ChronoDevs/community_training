<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryListingTable extends Migration
{
    public function up()
    {
        Schema::create('category_listing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('listing_id');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('listing_id')->references('id')->on('listings');
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_listing');
    }
}
