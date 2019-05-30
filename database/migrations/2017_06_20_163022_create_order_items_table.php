<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_id')->unsigned()->index();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->integer('cryptocurrency_id')->unsigned()->index();
            $table->foreign('cryptocurrency_id')->references('id')->on('cryptocurrencies');

            $table->decimal('price_per_unit', 18, 6);
            $table->decimal('crypto_amount',17,8);
            $table->decimal('fiat_amount', 18,6);
            $table->dateTime('filled_at')->nullable();
            $table->dateTime('transferred_at')->nullable();
            $table->string('blockchain_address')->nullable();
            $table->string('blockchain_transaction_id')->nullable();

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
        Schema::dropIfExists('order_items');
    }
}
