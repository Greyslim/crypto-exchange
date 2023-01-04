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
        Schema::create('relation_cryptocurrency_token', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cryptocurrency_token_to_id')->unsigned();
            $table->foreign('cryptocurrency_token_to_id','f_token_to_id')->references('id')->on('cryptocurrency_tokens')->onDelete('Cascade')->name;
            $table->bigInteger('cryptocurrency_token_from_id')->unsigned();
            $table->foreign('cryptocurrency_token_from_id','f_token_from_id')->references('id')->on('cryptocurrency_tokens')->onDelete('Cascade');
            $table->double('price')->unsigned();
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
        Schema::dropIfExists('relation_cryptocurrency_token');
    }
};
