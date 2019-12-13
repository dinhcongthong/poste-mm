<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParamRequest extends FormRequest
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
            'ip_news_type' => 'nullable',
            'sl_news_type' => 'nullable|required_without:ip_news_type',
            'ip_tag_type' => 'nullable',
            'sl_tag_type' => 'nullable|required_without:ip_tag_type'
        ];
    }

    /**
     * Get the validation message that apply to the rerquest
     * 
     * @return array
     */ 
    public function messages() {
        return [
            'sl_news_type.required_without' => 'Please input or choose News Type',
            'sl_tag_type.required_without' => 'Please input or choose Tag Type'
        ];
    }

}
