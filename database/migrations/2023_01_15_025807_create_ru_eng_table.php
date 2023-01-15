<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ru_eng', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ru_word_id');
            $table->unsignedBigInteger('eng_word_id');

            $table->foreign('ru_word_id')->references('id')->on('ru_word');
            $table->foreign('eng_word_id')->references('id')->on('eng_word');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ru_eng');
    }
};
