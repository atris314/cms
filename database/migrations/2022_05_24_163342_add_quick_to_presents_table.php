<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuickToPresentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presents', function (Blueprint $table) {
            $table->string('quick')->nullable();
            $table->integer('quickprice')->nullable();
            $table->tinyInteger('currency')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presents', function (Blueprint $table) {
            //
        });
    }
}
