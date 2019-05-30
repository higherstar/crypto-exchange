<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FiatCurrency extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function isFiat()
    {
        return true;
    }

    public function isCrypto()
    {
        return false;
    }
}
