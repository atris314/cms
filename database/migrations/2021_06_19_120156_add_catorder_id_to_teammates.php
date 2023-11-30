<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCatorderIdToTeammates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teammates', function (Blueprint $table) {
            $table->unsignedInteger('catorder_id')->nullable();

            $table->foreign('catorder_id')->references('id')->on('catorders');
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
