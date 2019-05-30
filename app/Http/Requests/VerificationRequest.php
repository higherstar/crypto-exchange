<?php

namespace App\Http\Requests;

use App\Verification;
use Illuminate\Foundation\Http\FormRequest;

class VerificationRequest extends FormRequest
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
            'document_type' => 'required|in:' . implode(',',Verification::DOCUMENT_TYPES),
            'civil_id_front_file' => "required_if:document_type," . Verification::CIVIL_ID . "|image|max:2048",
            'civil_id_back_file' => 'required_if:document_type,' . Verification::CIVIL_ID . '|image|max:2048',
            'passport_file' => 'required_if:document_type,' . Verification::PASSPORT . '|image|max:2048',
        ];
    }

    public function messages(){
        return [
            'civil_id_front_file.required_if' => 'Civil ID (front) upload is required',
            'civil_id_back_file.required_if' => 'Civil ID (back) upload is required',
            'passport_file.required_if' => 'Passport upload is required',
            'passport_file.size' => ':attribute is too large, must be 2MB or smaller.',
        ];
    }
}
