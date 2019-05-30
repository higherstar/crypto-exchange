<?php
/**
 * Created by PhpStorm.
 * User: Snake
 * Date: 11/18/17
 * Time: 4:06 AM
 */

namespace App\Services;

use App\Interfaces\SMS\NexmoSMS;
use App\Interfaces\SMS\SMSProviderInterface;
use App\MobileVerification;
use App\User;
use Carbon\Carbon;
use Response;

/**
 * Class MobileVerificationService
 * @package App\Services
 */
class MobileVerificationService
{
    public $smsProvider;

    /**
     * MobileVerificationService constructor.
     */
    public function __construct(SMSProviderInterface $SMSProvider)
    {
        $this->smsProvider = $SMSProvider;
    }


    /**
     * This method simply sends to the mobile_number provided a random 6-digit code for verification.
     * @param $mobile_number
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCode($mobile_number, User $user)
    {
        //Get the latest mobile verification request for that mobile number and user
        $mobileVerification = MobileVerification::getLatestVerification($mobile_number,$user, false);

        //TODO: Decide whether to send the API request even though it expired or reject it from our system
//        if(!is_null($mobileVerification))
//        {
//            if(Carbon::now() < $mobileVerification->expires_at)
//            {
//                return true;
//            }
//        }

        //
        $response = $this->smsProvider->sendVerificationCode("965".$mobile_number);

        if(key_exists('error', $response))
        {
            return Response::json($response, 500);
        }

        $mobileVerification = new MobileVerification();
        $mobileVerification->mobile_number = $mobile_number;
        $mobileVerification->user_id = $user->id;

        if($this->smsProvider instanceof NexmoSMS)
        {
            $mobileVerification->expires_at = Carbon::now()->addMinutes(5);
            $extra_data = $mobileVerification->extra_data;
            $extra_data['nexmo_request'] = $response;
            $mobileVerification->extra_data = $extra_data;
        }

        $mobileVerification->save();

        return Response::json($response, 200);
    }

    /**
     * This method verified the code submitted against a mobile number.
     * @param $code
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     * @internal param $mobile_number
     */
    public function verifyCode($mobile_number, User $user, $code)
    {
        //Get the latest non-verified mobile verification request for that mobile number
        $mobileVerification = MobileVerification::getLatestVerification($mobile_number, $user);

        //If none was found, return false
        if(is_null($mobileVerification))
        {
            return Response::json(['success' => false, 'error' => "Invalid verification request. Please submit a new one"], 500);
        }

        //If the code is a match, update the verification request timestamp and return true
        $response = $this->smsProvider->checkVerificationCode($code, $mobileVerification);
        if(!key_exists('error', $response))
        {
            $verified_at = Carbon::now();
            $mobileVerification->verified_at = $verified_at;
            $mobileVerification->save();

            $user->mobile_number_verified_at = $verified_at;
            $user->save();
            return Response::json($response, 200);
        }

        return Response::json($response, 500);
    }
}