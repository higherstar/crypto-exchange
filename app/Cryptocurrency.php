<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cryptocurrency extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function isFiat()
    {
        return false;
    }

    public function isCrypto()
    {
        return true;
    }
}
