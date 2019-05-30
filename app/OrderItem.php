<?php

namespace App;

use App\API\YallaBit\Helpers\Decimals;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function cryptocurrency()
    {
        return $this->belongsTo(Cryptocurrency::class);
    }

    public function fiat_currency()
    {
        return $this->order->fiat_currency;
    }

    public function getCryptocurrencyName()
    {
        return $this->cryptocurrency->name;
    }

    public function getFiatCurrencyName()
    {
        return $this->fiat_currency()->name;
    }

    public function getPricePerUnitAttribute($value)
    {
        return Decimals::calculatedNumberOfDecimals($value);
    }

    public function getFiatAmountAttribute($value){
        return number_format($value,3);
    }
}
