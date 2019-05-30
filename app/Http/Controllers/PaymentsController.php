<?php

namespace App\Http\Controllers;

use App\API\YallaBit\GoTap;
use App\Http\Requests\GoTapResponseRequest;
use App\Http\Requests\PaymentInitializationRequest;
use App\Mail\Receipt;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Log;

class PaymentsController extends Controller
{

    public function index()
    {

    }

    public function store(PaymentInitializationRequest $request)
    {
        $payment = Payment::createAndInitialize($request->order);
        return Redirect::to($payment->payment_url);
    }

    public function response(GoTapResponseRequest $request)
    {
        //validation passes
        Log::debug("payment complete for ref: $request->ref");
    }

    /**
     * @param GoTapResponseRequest $request
     * @return string
     */
    public function result(GoTapResponseRequest $request)
    {
        $payment = $request->payment;

        $payment->saveGotapResponse($request);

        $order = $payment->order;

        if($payment->result == "SUCCESS")
        {
            \Mail::to(\Auth::user())->queue(new Receipt($order));
        }

        return view('payments.receipt', compact('order'));
//        return Redirect::route('payments.receipt');
    }

    public function receipt()
    {
        return view('payments.receipt');
    }
}
