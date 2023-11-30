<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changes', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(0);
            $table->unsignedInteger('couponpresent_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('coin_id');

            $table->foreign('couponpresent_id')->references('id')->on('couponpresents');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('coin_id')->references('id')->on('coins');
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
        Schema::dropIfExists('changes');
    }
}
