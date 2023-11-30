<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneToTeammatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teammates', function (Blueprint $table) {
            $table->string('fathername')->nullable();
            $table->string('codemeli')->nullable();
            $table->string('mobile')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->tinyInteger('maritalstatus')->default(0);
            $table->string('skill')->nullable();
            $table->tinyInteger('lasteducation')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teammates', function (Blueprint $table) {
            //
        });
    }
}
