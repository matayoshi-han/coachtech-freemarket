<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->unique()->constrained()->onDelete('cascade');
            $table->integer('price')->comment('購入時の金額');
            $table->string('payment_method')->comment('支払い方法');
            $table->string('shipping_postal_code')->comment('配送先郵便番号');
            $table->string('shipping_address')->comment('配送先住所');
            $table->string('shipping_building')->nullable()->comment('配送先建物名');
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
        Schema::dropIfExists('orders');
    }
}
