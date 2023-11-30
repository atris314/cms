<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponpresentCoinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('couponpresent_coin', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('couponpresent_id');
            $table->unsignedInteger('coin_id');

            $table->foreign('couponpresent_id')->references('id')->on('couponpresents');
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
        Schema::dropIfExists('couponpresent_coin');
    }
}
