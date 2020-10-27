<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutfitItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outfit_items', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('outfit_id')->unsigned()->index();
            $table->bigInteger('item_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('outfit_id')->references('id')->on('outfits');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('outfit_items');
    }
}
