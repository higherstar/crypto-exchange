<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckMobileVerificationCodeRequest;
use App\Http\Requests\MobileVerificationRequest;
use App\Interfaces\SMS\SMSProviderInterface;
use App\Services\MobileVerificationService;

class MobileVerificationController extends Controller
{
    public $mobileVerificationService;

    public function __construct(SMSProviderInterface $SMSProvider)
    {
        $this->mobileVerificationService = new MobileVerificationService($SMSProvider);
    }

    /**
     * Send a verification code to the mobile provided
     * @param MobileVerificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(MobileVerificationRequest $request)
    {
        return $this->mobileVerificationService->sendCode($request->get('mobile_number'),\Auth::user());
    }


    /**
     * Check the code provided for the mobile verification request
     * @param CheckMobileVerificationCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(CheckMobileVerificationCodeRequest $request)
    {
        return $this->mobileVerificationService->verifyCode($request->get('mobile_number'),\Auth::user(), $request->get('code'));
    }

}
