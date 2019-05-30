<?php

namespace App\API\YallaBit\Helpers;
/**
 * Created by PhpStorm.
 * User: Talal
 * Date: 7/4/2017
 * Time: 4:17 AM
 */
class Decimals
{
    public static function calculatedNumberOfDecimals($value)
    {
        if($value > 0.100)
        {
            return number_format($value, 3,null,'');
        }
        else if ($value > 0.0100) {
            return number_format($value, 4,null,'');
        }
        else if ($value > 0.00100) {
            return number_format($value, 5,null,'');
        }
        else{
            return $value;
        }
    }
}