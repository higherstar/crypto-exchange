<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptocurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cryptocurrencies', function (Blueprint $table) {
            $table->increments('id');

            $table->boolean('published');

            $table->string('name');
            $table->string('shortname');

            $table->softDeletes();
            $table->timestamps();
        });

        $now = \Carbon\Carbon::now();
        DB::table('cryptocurrencies')->insert([
            [
                'published' => true,
                'name' => 'Bitcoin',
                'shortname' => 'BTC',
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                'published' => true,
                'name' => 'Litecoin',
                'shortname' => 'LTC',
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                'published' => true,
                'name' => 'Ripple',
                'shortname' => 'XRP',
                "created_at" => $now,
                "updated_at" => $now,
            ],
            [
                'published' => false,
                'name' => 'Ethereum',
                'shortname' => 'ETH',
                "created_at" => $now,
                "updated_at" => $now,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cryptocurrencies');
    }
}
