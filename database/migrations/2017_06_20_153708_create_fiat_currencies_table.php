<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiatCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiat_currencies', function (Blueprint $table) {
            $table->increments('id');

            $table->boolean("published");
            $table->string('name');
            $table->string('shortname');
            $table->string('country');

            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('fiat_currencies')->insert(
            [
                [   "published" => true,
                    "name"  => "Kuwaiti Dinar",
                    "shortname" => "KWD",
                    "country" => "Kuwait",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now(),
                ],
                [   "published" => true,
                    "name"  => "United States Dollars",
                    "shortname" => "USD",
                    "country" => "USA",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now(),
                ],
                [   "published" => false,
                    "name"  => "Euro",
                    "shortname" => "EUR",
                    "country" => "Europe",
                    "created_at" => \Carbon\Carbon::now(),
                    "updated_at" => \Carbon\Carbon::now(),
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
        Schema::dropIfExists('fiat_currencies');
    }
}
