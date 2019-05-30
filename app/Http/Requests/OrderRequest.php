<?php

namespace App\Http\Requests;

use App\TradingPair;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class OrderRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $allowed_pairs = strtolower( // lower everything to match
                            str_replace('/USD', 'kwd',  //replace the /usd with KWD because we're sending xxxkwd
                                implode(",", // convert to string
                                    TradingPair::published()->pluck('display_name')->toArray() // Get All the published pairs display name
                                )
                            )
                        );

        return [
            'trading_pair' => "required|in:$allowed_pairs",
            $request->get('trading_pair') . '.*' => 'required|numeric', // checks kwd and others so no need to say required below.
            $request->get('trading_pair') . '.kwd' => 'numeric|min:5|max:3000',
            'fiat_based' => 'required|boolean',
        ];
    }
}
