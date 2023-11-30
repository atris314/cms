<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCatalogIdToCatusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catusers', function (Blueprint $table) {
            $table->unsignedInteger('catalog_id');
            $table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catusers', function (Blueprint $table) {
            //
        });
    }
}
