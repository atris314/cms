<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOredernextpaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oredernextpays', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');

            $table->uuid('uuid')->unique();
            $table->uuid('api_key')->nullable();
            $table->boolean('sandbox')->default(0)->nullable();
            $table->string('payer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('allowed_card')->nullable();
            $table->string('amount')->nullable();
            $table->string('status')->default(0);
            $table->string('callback_uri')->nullable();
            $table->string('payer_desc')->nullable();
            $table->string('auto_verify')->nullable();
            $table->string('custom_json_fields')->nullable();
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
        Schema::dropIfExists('oredernextpays');
    }
}
