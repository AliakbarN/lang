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
        Schema::table('eng_word', function (Blueprint $table) {
            $table->text('synonyms');
            $table->string('audio', 200);
            $table->string('spelling', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eng_word', function (Blueprint $table) {
            //
        });
    }
};
