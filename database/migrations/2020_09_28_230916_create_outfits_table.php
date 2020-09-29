<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutfitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outfits', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->unsigned()->index();
            $table->integer('winterjacket_id');
            $table->integer('jacket_id')->nullable();
            $table->integer('top_id')->nullable();
            $table->integer('bottom_id')->nullable();
            $table->string('image_url')->nullable();
            $table->string('season')->nullable();
            $table->string('style')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outfits');
    }
}
