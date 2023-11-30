<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class
CreateTeammatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teammates', function (Blueprint $table) {
            $table->id();
            $table->date('borndate');
            $table->string('major');
            $table->string('residence');
            $table->text('resume');
            $table->string('education');
            $table->tinyInteger('status');
            $table->text('description')->nullable();

            $table->unsignedInteger('catwork_id');
            $table->unsignedInteger('photo_id');
            $table->unsignedInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('photo_id')->references('id')->on('photos');
            $table->foreign('catwork_id')->references('id')->on('catworks');
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
        Schema::dropIfExists('teammates');
    }
}
