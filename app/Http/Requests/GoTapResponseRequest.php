<?php

namespace App\Http\Requests;

use App\API\YallaBit\GoTap;
use App\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use Log;

class GoTapResponseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ref'     => 'required',
            'result'  => 'required',
            'payid'   => 'required',
            'amt'     => 'required|numeric',
            'crdtype' => 'required',
            'trackid' => 'required',
            'hash'    => 'required',
//            'ddd' => 'required',
        ];
    }

    /**
     * Hook onto validator's 'after' method for further processing after validation
     *
     * @param $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ( !$this->checkDataLegitimacy() ) {
                $validator->errors()->add('hash', 'The hash in the parameter does not match the generated one for validation');
            }else{
                // If everything is in order, then let's try to fetch the payment object from the track ID
                $this->payment = Payment::where('track_id', '=', $this->trackid)->first();
                if( !isset($this->payment) )
                {
                    // if nothing was fetched, then add an error
                    $validator->errors()->add('trackid', 'Track ID is not found. Rejecting request');
                }
            }
        });
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        // Log the errors before creating the response
        $request = $this->request;
        $validator = $this->getValidatorInstance();
        Log::critical('GoTapResponseRequest: Validation Error: ');
        Log::critical($validator->errors()->getMessages());
        Log::critical('Response parameters:');
        Log::critical($output = implode(', ', array_map(
            function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
            $request->all(),
            array_keys($request->all())
        )));

        // send back a json error without the details
        if ($this->expectsJson()) {
            return new JsonResponse(['incorrect_request' => 'true'], 422);
        }

        // Redirect home without sending errors when validation fails.
        return $this->redirector->to(route('home'));
    }

    private function checkDataLegitimacy()
    {
        return GoTap::validateResponseHash($this->ref, $this->result, $this->trackid, $this->hash);
    }
//        return 'this failed';
//

//        return Redirect::home();
//    }
}
