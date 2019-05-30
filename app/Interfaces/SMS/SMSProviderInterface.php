<?php
/**
 * Created by PhpStorm.
 * User: Snake
 * Date: 11/18/17
 * Time: 4:42 AM
 */

namespace App\Interfaces\SMS;


use App\MobileVerification;

interface SMSProviderInterface
{
    public function sendSMS($message, $mobile_number);

    public function sendVerificationCode($mobile_number);

    public function checkVerificationCode($code, MobileVerification $request);
}