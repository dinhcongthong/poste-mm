<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRelatedRequest extends FormRequest
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
            'related_name'  => 'required|max:191',
            'related_address' => 'required|max:191',
            'related_phone'   => 'nullable|max:191',
            'related_email'         => 'nullable|email|max:191',
            'related_website'  => 'nullable'
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'related_name.required'     => 'Please input name',
            'related_name.max'          => 'Name too long',
            'related_address.required'  => 'Please input address!',
            'related_address.max'       => 'Address too long',
            'related_phone.max'         => 'Phone too large',
            'related_email.email'       => 'Mail was wrong',
            'related_email.max'         => 'Email is too long',
        ];
    }
}
