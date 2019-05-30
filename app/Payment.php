<?php

namespace App;

use App\API\YallaBit\GoTap;
use App\Http\Requests\GoTapResponseRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;

class Payment extends Model
{

    protected $dates = ['paid_at'];
    public static function createAndInitialize(Order $order)
    {
        $payment = new Payment();
        $payment->amount = $order->getDueAmount();
        $payment->order_id = $order->id;
        $payment->track_id = strtolower(uniqid());

        $gotap = new GoTap();
        $response = $gotap->makePaymentRequest($payment);
        if($response->ResponseCode == '0' && strtolower($response->ResponseMessage) == "success")
        {
            $payment->payment_url = $response->PaymentURL;
            $payment->reference_id = $response->ReferenceID;

            $payment->save();
        }
        else
        {
            throw new Exception("Payment could not be initialized");
        }

        return $payment;
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function saveGotapResponse(GoTapResponseRequest $request)
    {
        // All the below go through validation, and will only be set if the current value is NULL
        $this->card_number_last_4 = $request->crd;
        $this->result = $request->result;
        $this->payment_method = $request->crdtype;
        $this->response_hash = $request->hash;
        $this->payment_id = $request->payid;

        if($request->result == "SUCCESS")
            $this->paid_at = Carbon::now();

        $this->save();
    }

    #region Model Mutators
    public function setPaymentMethodAttribute($value)
    {
        $options = ["KNET","VISA","MASTERCARD","AMEX"];
        if($this->payment_method === NULL)
        {
            if(in_array($value, $options))
            {
                $this->attributes['payment_method'] = $value;
            }
            else
            {
                $this->attributes['payment_method'] = "UNKNOWN";
            }
        }
    }

    public function setPaidAtAttribute($value)
    {
        if($this->paid_at === NULL)
            $this->attributes['paid_at'] = $value;
    }

    public function setResultAttribute($value)
    {
        if($this->result === NULL)
            $this->attributes['result'] = $value;
    }

    public function setCardNumberLast4Attribute($value)
    {
        if($this->result === NULL && is_numeric($value))
            $this->attributes['result'] = $value;
    }

    public function setResponseHashAttribute($value)
    {
        if($this->response_hash === NULL)
            $this->attributes['response_hash'] = $value;
    }
    #endregion

}
