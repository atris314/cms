<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentresidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentresids', function (Blueprint $table) {
            $table->id();
            $table->string('resid_code')->nullable();
            $table->unsignedInteger('photo_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('present_id');

            $table->foreign('present_id')->references('id')->on('presents');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('photo_id')->references('id')->on('photos');
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
        Schema::dropIfExists('presentresids');
    }
}
