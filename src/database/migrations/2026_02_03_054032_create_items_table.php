<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('image_url', 255);
            $table->foreignId('category_id')->constrained('categories');
            $table->string('item_state', 30);
            $table->string('item_name', 50);
            $table->string('item_brand', 50)->nullable();
            $table->string('item_description', 300);
            $table->integer('item_amount');
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
        Schema::dropIfExists('items');
    }
}
