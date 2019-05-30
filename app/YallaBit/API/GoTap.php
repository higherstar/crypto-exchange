<?php
/**
 * Created by PhpStorm.
 * User: Talal
 * Date: 6/26/2017
 * Time: 8:28 AM
 */

namespace App\API\YallaBit;


use App\Order;
use App\Payment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GoTap
{
    public $http_client;
    public function __construct()
    {
        $test_url = "http://tapapi.gotapnow.com/TapWebConnect/Tap/WebPay/";
        $this->http_client = new Client([
            'base_uri' => $test_url,
            'verify' => false,
        ]);
    }

    /**
     * Generates the authentication hash has that is used during Requests sent to GoTap
     *
     * @param $reference_id
     * @param $amount
     * @param $mobile
     * @return string
     */
    private function generateAuthenticationHash($track_id, $amount, $mobile)
    {
        $APIKey = "1tap7"; //Your API Key Provided by Tap
        $MerchantID = 1014; //Your ID provided by Tap
        $UserName = "test"; //Your Username under TAP.
        $ref = $track_id; //This is a reference given by you while creating an invoice. (Details can be found in "Create a Payment" endpoint)
        $Mobile = $mobile; //This is the mobile number for the customer you are sending the invoice to. (Details can be found in "Create a Payment" endpoint)
        $CurrencyCode = "KWD"; //This is the currency of the invoice you are creating. (Details can be found in "Create a Payment" endpoint)

        $str = 'X_MerchantID'.$MerchantID.'X_UserName'.$UserName.'X_ReferenceID'.$ref.'X_Mobile'.$Mobile.'X_CurrencyCode'.$CurrencyCode.'X_Total';
        $str .= $amount;
        $signature = hash_hmac('sha256', $str, $APIKey);
//        \Log::debug($signature);
        return $signature;
    }

    /**
     * Initiate a "Create Payment" request to GoTap and return the results.
     *
     * @param Payment $payment
     * @param $amount
     * @param $description
     * @return mixed
     */
    public function makePaymentRequest(Payment &$payment)
    {
        $uri = "PaymentRequest";

        $payment->request_hash = $this->generateAuthenticationHash($payment->track_id, $payment->amount, '96596061886');
        $description = $payment->order->getDescription();
        $payment_payload = [
          "CustomerDC" => [
            "Email"     => "billing@yallabit.com",
            "Mobile"    => "96596061886",
            "Name"      => "YallaBit Customer",
          ],
          "lstProductDC" => [ 0 =>[
              "CurrencyCode"    => "KWD",
              "Quantity"        => 1,
              "TotalPrice"      => $payment->amount,
              "UnitDesc"        => $description,
              "UnitName"        => $description,
              "UnitPrice"       => $payment->amount
            ]],
          "lstGateWayDC" => [
              0 => ["Name" => "ALL"],
          ],
          "MerMastDC" => [
            "AutoReturn"    => "Y",
            "ErrorURL"      => "",    //todo: custom error
            "HashString"    => $payment->request_hash, // is this deprecated?
            "LangCode"      => "EN",
            "MerchantID"    => "1014",
            "Password"      => "test",
            "PostURL"       => route('payments.response'), //todo: post url
            "ReferenceID"   => $payment->track_id,
            "ReturnURL"     => route('payments.result'),
            "UserName"      => "test"
          ]
        ];

        return \GuzzleHttp\json_decode($this->http_client->post($uri,['form_params' => $payment_payload] )->getBody());
    }

    /**
     * Validate the request by comparing the hash that was received against a generated hash locally.
     *
     * @param $reference_id
     * @param $result
     * @param $track_id
     * @param $hash
     * @return bool
     */
    public static function validateResponseHash($reference_id, $result, $track_id, $hash)
    {

        // Create a hash string from the passed data + the data that are related to you.
        $APIKey = "1tap7"; //Your API Key Provided by Tap
        $MerchantID = 1014; //Your ID provided by Tap
        $data = 'x_account_id'.$MerchantID.'x_ref'.$reference_id.'x_result'.$result.'x_referenceid'.$track_id.'';
        $generated_hash = hash_hmac('sha256', $data, $APIKey);

        // Legitimate the request by comparing the hash string you computed with the one passed with the request
        return ($generated_hash == $hash);
    }


}