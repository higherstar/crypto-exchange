<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_id')->unsigned()->index();
            $table->foreign('order_id')->references('id')->on('orders');

            $table->decimal("amount", 10,3);

            $table->string("reference_id")->nullable();
            $table->string('payment_id')->nullable();
            $table->string("track_id");

            $table->string("payment_method")->nullable();
            $table->string("result")->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->string("card_number_last_4")->nullable();
            $table->string("request_hash")->nullable();
            $table->string("response_hash")->nullable();

            $table->string("payment_url")->nullable();

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
        Schema::dropIfExists('payments');
    }
}
