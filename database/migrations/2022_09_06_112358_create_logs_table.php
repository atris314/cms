<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->integer('user_id')->unsigned()->nullable();
            $table->text('ip');
            $table->text('agent');
            $table->text('controller')->nullable();
            $table->text('method')->nullable();
            $table->text('input')->nullable();
            $table->text('output')->nullable();
            $table->text('route')->nullable();
            $table->text('http_method')->nullable();
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
        Schema::dropIfExists('logs');
    }
}
