<?php

namespace App\Http\Requests;

use App\Order;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;

class PaymentInitializationRequest extends FormRequest
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
            'oid' => 'required'
        ];
    }

    /**
     * Hook onto validator's 'after' method for further processing after validation
     *
     * @param $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator){
            try{ // check if we can decrypt properly. and replace the variable.
                $this->order = Order::findOrFail(decrypt($this->oid));
            } catch (DecryptException $e){ // if not, then add errors
                $validator->errors()->add('oid', 'OID is not a valid key.');
            } catch (ModelNotFoundException $e)
            {
                $validator->errors()->add('oid', 'Order ID does not exist.');
            }
        });
    }
}
