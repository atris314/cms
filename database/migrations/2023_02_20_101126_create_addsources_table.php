<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddsourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addsources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('brandname');
            $table->string('website')->nullable();
            $table->string('job');
            $table->text('address');
            $table->string('activitytime');
            $table->text('description');

            $table->unsignedInteger('catorder_id')->nullable();
            $table->foreign('catorder_id')->references('id')->on('catorders');

            $table->unsignedInteger('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('provinces');

            $table->unsignedInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('addsources');
    }
}
