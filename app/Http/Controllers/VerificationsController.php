<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerificationRequest;
use App\MobileVerification;
use App\Verification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
class VerificationsController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $currentStage = $user->current_verification_stage;
        $mobile_number = $user->mobile_number;
        $mobile_status = !is_null($user->mobile_number_verified_at);
        $mobile_verification = MobileVerification::getLatestVerification($mobile_number, $user, false);
        if(!is_null($mobile_verification))
        {
            $time_left = $mobile_verification->expires_at->diffInSeconds(Carbon::now());
            $time_left = gmdate('i:s', $time_left);
            $mobile_verification = true;
        }
        else
        {
            $time_left = "5:00";
            $mobile_verification = false;
        }


        return view('verifications.index', compact('currentStage', 'mobile_number',
            'mobile_status', 'mobile_verification', 'time_left'));
    }

    public function store(VerificationRequest $request)
    {
        switch($request->get('document_type'))
        {
            case Verification::CIVIL_ID:
                $org_file_path = $request->file('civil_id_front_file')->storeAs("private_uploads/uid_". Auth::user()->id . "/" . strtolower(Verification::CIVIL_ID) . "/", '' . date("Y-m-d_His_") . uniqid() . "." . $request->file('civil_id_front_file')->extension());
                $org_file_path_2 = $request->file('civil_id_back_file')->storeAs("private_uploads/uid_". Auth::user()->id . "/" . strtolower(Verification::CIVIL_ID) . "/", '' . date("Y-m-d_His_") . uniqid() . "." . $request->file('civil_id_back_file')->extension());
                break;
            case Verification::PASSPORT:
                $org_file_path = $request->file('passport_file')->storeAs("private_uploads/uid_". Auth::user()->id . "/" . strtolower(Verification::PASSPORT) . "/", '' . date("Y-m-d_His_") . uniqid() . "." . $request->file('passport_file')->extension());
                break;
            default:
                return redirect()->back()-with('message', 'Could not determine the document type!');
                break;
        }

        $verification = new Verification;
        $verification->user_id = Auth::user()->id;
        $verification->ip_address = $request->ip();

        $verification->document_type = strtoupper($request->get('document_type'));
        $verification->file_path_1 = $org_file_path;
        $verification->file_path_2 = isset($org_file_path_2) ? $org_file_path_2 : null;

        $verification->stage = Verification::STAGE_REVIEW;

        $verification->save();

        return redirect()->route('verifications.index')->with('success_message', 'Verification documents has been successfully submitted. Please allow 24 hours for a response.');
    }
}
