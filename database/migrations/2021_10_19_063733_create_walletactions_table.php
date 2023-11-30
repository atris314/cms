<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('walletactions', function (Blueprint $table) {
            $table->id();
            $table->char('payment_id',32)->index();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('paid');
            $table->unsignedTinyInteger('status')->default(1);
            $table->text('invoice_details')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('transaction_result')->nullable();

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
        Schema::dropIfExists('walletactions');
    }
}
