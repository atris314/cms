<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFootballToFootballpresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('footballpres', function (Blueprint $table) {
            $table->unsignedInteger('football_id');
            $table->foreign('football_id')->references('id')->on('footballs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('footballpres', function (Blueprint $table) {
            //
        });
    }
}
