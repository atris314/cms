<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponpresentUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('couponpresent_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('couponpresent_id');
            $table->unsignedInteger('user_id');

            $table->foreign('couponpresent_id')->references('id')->on('couponpresents');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('couponpresent_user');
    }
}
