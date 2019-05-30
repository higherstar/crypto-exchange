<?php

namespace App;

use App\API\YallaBit\Helpers\Decimals;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;

class TradingPair extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The below 3 functions, are only used in the homepage to display the prices instantly
     * @return string
     */
    public static function btcusd_kwd_last_price()
    {
        return static::where('display_name', 'btc/usd')->first()->kwd_last_price;
    }
    public static function ltcusd_kwd_last_price()
    {
        return static::where('display_name', 'ltc/usd')->first()->kwd_last_price;
    }
    public static function xrpusd_kwd_last_price()
    {
        return static::where('display_name', 'xrp/usd')->first()->kwd_last_price;
    }

    /**
     * Determine which foreign key to use for the relationship of base_currency.
     * Whether it's fiat_currencies table or cryptocurrencies and link the correct one.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function base_currency()
    {
        if(isset($this->fiat_base_currency_id))
        {
            return $this->belongsTo(FiatCurrency::class,  'fiat_base_currency_id', 'id');
        }
        else
        {
            return $this->belongsTo(Cryptocurrency::class, 'crypto_base_currency_id', 'id');
        }
    }


    /**
     * Determine which foreign key to use for the relationship of quote_currency.
     * Whether it's fiat_currencies table or cryptocurrencies and link the correct one.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quote_currency()
    {
        if(isset($this->fiat_quote_currency_id))
        {
            return $this->belongsTo(FiatCurrency::class,  'fiat_quote_currency_id', 'id');
        }
        else
        {
            return $this->belongsTo(Cryptocurrency::class, 'crypto_quote_currency_id', 'id');
        }
    }

    public function scopePublished()
    {
        return static::where('published', true);
    }

    public function setQuoteLastPriceAttribute($value)
    {
        //set the quote price
        $this->attributes['quote_last_price'] = $value;

        //set the KWD price (this will not work if the quote is not USD)
        //TODO:: fix this, read above
        $this->kwd_last_price = $this->convertToKWDSaleLastPrice($value);
    }

    private function convertToKWDSaleLastPrice($price)
    {
        //TODO: Remove all number formats from model. Number formats should be in Controller
        $multiplier = pow(10,$this->number_of_decimals);
        $kwd_last_price =  ( $price * (1 + 0.0025) / (1 - 0.08) ) * (0.30700);
        return number_format(ceil($kwd_last_price * $multiplier ) / $multiplier, $this->number_of_decimals, '.','');
    }

    public function getStrippedDisplayNameAttribute(){
        return strtolower(str_replace('/', '', $this->display_name));
    }

    public function getRoundedKwdLastPriceAttribute(){
        $multiplier = pow(10,$this->number_of_decimals);
        return number_format(ceil($this->kwd_last_price * $multiplier) / $multiplier, $this->number_of_decimals, '.', '');
    }
    public function getRoundedUsdLastPriceAttribute(){
        return number_format(ceil($this->usd_last_price * 100) / 100, 2,'.', '');
    }

    public function getNumberOfDecimalsAttribute(){
        return $this->quote_last_price > 1 ? 3 : 4;
    }

    public function getKwdLastPriceAttribute($value){
        return Decimals::calculatedNumberOfDecimals($value);
    }
}
