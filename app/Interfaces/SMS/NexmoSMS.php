<?php
/**
 * Created by PhpStorm.
 * User: Snake
 * Date: 11/18/17
 * Time: 4:42 AM
 */

namespace App\Interfaces\SMS;


use App\MobileVerification;
use Nexmo\Verify\Verification;
use Log;
use Exception;

class NexmoSMS implements SMSProviderInterface
{
    private $nexmo;
    const BRAND = 'YallaBit';

    public function __construct()
    {
        $this->nexmo = $nexmo = app('Nexmo\Client');
    }

    public function sendSMS($message, $mobile_number)
    {
        try{
            $response = $this->nexmo->message()->send([
                'to'   => $mobile_number,
                'from' => 'NXSMS', //TODO: Fill this later with our sender ID.
                'text' => $message,
            ]);

            return [
                'success'   => $response->getStatus() === '0',
                'status'    => $response->getStatus(),
                'data'   => $response->getResponseData(),
                ];
        }
        catch (Exception $e)
        {
            Log::error($e->getMessage(), ['message' => $message, 'mobile_number' => $mobile_number]);

            return [
                'success'   => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function sendVerificationCode($mobile_number)
    {
        try{
            $response = $this->nexmo->verify()->start(new Verification($mobile_number, self::BRAND));

            return [
                'success'   => $response->getStatus() === '0',
                'status'    => $response->getStatus(),
                'data'   => $response->getResponseData(),
            ];

        }
        catch (Exception $e)
        {
            Log::error($e->getMessage(), ['mobile_number' => $mobile_number]);

            return [
                'success'   => false,
                'error' => $e->getMessage()
            ];
        }
    }

    public function checkVerificationCode($code, MobileVerification $request)
    {
        try{
            $request_id = $request->extra_data['nexmo_request']['data']['request_id'];
            $response = $this->nexmo->verify()->check($request_id, $code);

            return [
                'success'   => true,
                'status'    => $response->getStatus() === '0',
                'data'   => $response->getResponseData(),
            ];
        }
        catch (Exception $e)
        {
            Log::error($e->getMessage(), ['code' => $code, 'request' => $request]);

            return [
                'success'   => false,
                'error' => $e->getMessage()
            ];
        }
    }
}