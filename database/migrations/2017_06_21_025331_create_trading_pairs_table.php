<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradingPairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('trading_pairs');
        Schema::create('trading_pairs', function (Blueprint $table) {
            $table->increments('id');

            $table->boolean('published');

            $table->integer('fiat_base_currency_id')->unsigned()->index()->nullable();
            $table->foreign('fiat_base_currency_id')->references('id')->on('fiat_currencies');

            $table->integer('crypto_base_currency_id')->unsigned()->index()->nullable();
            $table->foreign('crypto_base_currency_id')->references('id')->on('cryptocurrencies');

            $table->integer('fiat_quote_currency_id')->unsigned()->index()->nullable();
            $table->foreign('fiat_quote_currency_id')->references('id')->on('fiat_currencies');

            $table->integer('crypto_quote_currency_id')->unsigned()->index()->nullable();
            $table->foreign('crypto_quote_currency_id')->references('id')->on('cryptocurrencies');

            $table->string('display_name');

            $table->decimal("quote_last_price",17,8);
            $table->decimal("kwd_last_price",17,8);

            $table->dateTime('last_price_updated_at');


            $table->softDeletes();
            $table->timestamps();
        });

        $now = \Carbon\Carbon::now();
        DB::table('trading_pairs')->insert(
            [
                #region base: BTC
                [
                    "published" => true,
                    "fiat_base_currency_id" => null,
                    "crypto_base_currency_id" => DB::table('cryptocurrencies')->where('shortname', '=', 'BTC')->first()->id,
                    "fiat_quote_currency_id" => DB::table('fiat_currencies')->where('shortname', '=', 'USD')->first()->id,
                    "crypto_quote_currency_id" => null,
                    "display_name" => "BTC/USD",
                    'quote_last_price' => '100000.000',
                    'kwd_last_price' => '100000.000',
                    'last_price_updated_at' => $now,
                    "created_at" => $now,
                    "updated_at" => $now,
                ],
//                [
//                    "published" => false,
//                    "fiat_base_currency_id" => null,
//                    "crypto_base_currency_id" => DB::table('cryptocurrencies')->where('shortname', '=', 'BTC')->first()->id,
//                    "fiat_quote_currency_id" => DB::table('fiat_currencies')->where('shortname', '=', 'EUR')->first()->id,
//                    "crypto_quote_currency_id" => null,
//                    "display_name" => "BTC/EUR",
//                    'quote_last_price' => '100000.000',
//                    'kwd_last_price' => '100000.000',
//                    'last_price_updated_at' => $now,
//                    "created_at" => $now,
//                    "updated_at" => $now,
//                ],
                #endregion

                #region base: EUR
//                [
//                    "published" => false,
//                    "fiat_base_currency_id" => DB::table('fiat_currencies')->where('shortname', '=', 'EUR')->first()->id,
//                    "crypto_base_currency_id" => null,
//                    "fiat_quote_currency_id" => DB::table('fiat_currencies')->where('shortname', '=', 'USD')->first()->id,
//                    "crypto_quote_currency_id" => null,
//                    "display_name" => "EUR/USD",
//                    'quote_last_price' => '100000.000',
//                    'kwd_last_price' => '100000.000',
//                    'last_price_updated_at' => $now,
//                    "created_at" => $now,
//                    "updated_at" => $now,
//                ],
                #endregion

                #region base: XRP
                [
                    "published" => true,
                    "fiat_base_currency_id" => null,
                    "crypto_base_currency_id" => DB::table('cryptocurrencies')->where('shortname', '=', 'XRP')->first()->id,
                    "fiat_quote_currency_id" => DB::table('fiat_currencies')->where('shortname', '=', 'USD')->first()->id,
                    "crypto_quote_currency_id" => null,
                    "display_name" => "XRP/USD",
                    'quote_last_price' => '100000.000',
                    'kwd_last_price' => '100000.000',
                    'last_price_updated_at' => $now,
                    "created_at" => $now,
                    "updated_at" => $now,
                ],
//                [
//                    "published" => false,
//                    "fiat_base_currency_id" => null,
//                    "crypto_base_currency_id" => DB::table('cryptocurrencies')->where('shortname', '=', 'XRP')->first()->id,
//                    "fiat_quote_currency_id" => DB::table('fiat_currencies')->where('shortname', '=', 'EUR')->first()->id,
//                    "crypto_quote_currency_id" => null,
//                    "display_name" => "XRP/EUR",
//                    'quote_last_price' => '100000.000',
//                    'kwd_last_price' => '100000.000',
//                    'last_price_updated_at' => $now,
//                    "created_at" => $now,
//                    "updated_at" => $now,
//                ],
//                [
//                    "published" => false,
//                    "fiat_base_currency_id" => null,
//                    "crypto_base_currency_id" => DB::table('cryptocurrencies')->where('shortname', '=', 'XRP')->first()->id,
//                    "fiat_quote_currency_id" => null,
//                    "crypto_quote_currency_id" => DB::table('cryptocurrencies')->where('shortname', '=', 'BTC')->first()->id,
//                    "display_name" => "XRP/BTC",
//                    'quote_last_price' => '100000.000',
//                    'kwd_last_price' => '100000.000',
//                    'last_price_updated_at' => $now,
//                    "created_at" => $now,
//                    "updated_at" => $now,
//                ],
                #endregion

                #region base: LTC
                [
                    "published" => true,
                    "fiat_base_currency_id" => null,
                    "crypto_base_currency_id" => DB::table('cryptocurrencies')->where('shortname', '=', 'LTC')->first()->id,
                    "fiat_quote_currency_id" => DB::table('fiat_currencies')->where('shortname', '=', 'USD')->first()->id,
                    "crypto_quote_currency_id" => null,
                    "display_name" => "LTC/USD",
                    'quote_last_price' => '100000.000',
                    'kwd_last_price' => '100000.000',
                    'last_price_updated_at' => $now,
                    "created_at" => $now,
                    "updated_at" => $now,
                ],
//                [
//                    "published" => false,
//                    "fiat_base_currency_id" => null,
//                    "crypto_base_currency_id" => DB::table('cryptocurrencies')->where('shortname', '=', 'LTC')->first()->id,
//                    "fiat_quote_currency_id" => DB::table('fiat_currencies')->where('shortname', '=', 'EUR')->first()->id,
//                    "crypto_quote_currency_id" => null,
//                    "display_name" => "LTC/EUR",
//                    'quote_last_price' => '100000.000',
//                    'kwd_last_price' => '100000.000',
//                    'last_price_updated_at' => $now,
//                    "created_at" => $now,
//                    "updated_at" => $now,
//                ],
//                [
//                    "published" => false,
//                    "fiat_base_currency_id" => null,
//                    "crypto_base_currency_id" => DB::table('cryptocurrencies')->where('shortname', '=', 'LTC')->first()->id,
//                    "fiat_quote_currency_id" => null,
//                    "crypto_quote_currency_id" => DB::table('cryptocurrencies')->where('shortname', '=', 'BTC')->first()->id,
//                    "display_name" => "LTC/BTC",
//                    'quote_last_price' => '100000.000',
//                    'kwd_last_price' => '100000.000',
//                    'last_price_updated_at' => $now,
//                    "created_at" => $now,
//                    "updated_at" => $now,
//                ],
                #endregion

            ]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trading_pairs');
    }
}
