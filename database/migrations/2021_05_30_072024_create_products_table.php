<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->float('amount')->nullable();
            $table->text('description');

            $table->unsignedInteger('catorder_id');
            $table->unsignedInteger('photo_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('pack_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('photo_id')->references('id')->on('photos');
            $table->foreign('catorder_id')->references('id')->on('catorders');
            $table->foreign('pack_id')->references('id')->on('packs');
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
        Schema::dropIfExists('products');
    }
}
