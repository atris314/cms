<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackTeammateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_teammate', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('teammate_id');
            $table->unsignedInteger('pack_id');

            $table->foreign('teammate_id')->references('id')->on('teammates')->onDelete('cascade');
            $table->foreign('pack_id')->references('id')->on('packs')->onDelete('cascade');
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
        Schema::dropIfExists('pack_teammate');
    }
}
