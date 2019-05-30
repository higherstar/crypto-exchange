<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_item_id')->unsigned()->index();
            $table->foreign('order_item_id')->references('id')->on('order_items');

            $table->integer('trading_pair_id')->unsigned()->index();
            $table->foreign('trading_pair_id')->references('id')->on('trading_pairs');

            $table->string('type')->default('BUY');

            $table->decimal('amount', 17,8);
            $table->decimal('rate', 17,8);
            $table->decimal('fee', 17,8)->default('0.00000000');
            $table->decimal('filled_amount', 17,8)->default('0.00000000');


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
        Schema::dropIfExists('trades');
    }
}
