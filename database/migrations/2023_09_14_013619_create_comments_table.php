<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('listing_id');
            $table->unsignedBigInteger('user_id'); // Add this line to create the 'user_id' column
            $table->text('content');
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('listing_id')->references('id')->on('listings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
