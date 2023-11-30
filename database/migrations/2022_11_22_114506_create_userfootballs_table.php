<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserfootballsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userfootballs', function (Blueprint $table) {
            $table->id();
            $table->string('score');
            $table->string('award');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('football_id');
            $table->foreign('football_id')->references('id')->on('footballs');
            $table->unsignedInteger('footballpre_id');
            $table->foreign('footballpre_id')->references('id')->on('footballpres');
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
        Schema::dropIfExists('userfootballs');
    }
}
