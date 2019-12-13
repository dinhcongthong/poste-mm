<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'customer_id' => 'required|numeric',
            'position_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'utm_campaign' => 'required|unique:ads,utm_campaign,'.Request()->get('id').'|regex:/^[A-Za-z]*(?:_[A-Za-z0-9]+)*$/',
            'ip_url_image' => 'nullable',
            'ip_image' => 'nullable|required_without:ip_url_image|mimes:jpeg,jpg,png,gif|max:6144',
            'link' => 'required|active_url',
            'start_date' => 'required|date_format:m-d-Y',
            'end_date' => 'required|date_format:m-d-Y|after_or_equal:start_date',
            'note' => 'nullable',
            'status' => 'required|numeric'
        ];
    }

    /**
     * Get the validation messages that apply to the request
     * 
     * @return array
     */
    public function messages() {
        return [
            'name.required' => 'Name can not empty',
            'description.required' => 'Description can not empty',
            'customer_id.required' => 'Customer can not empty',
            'customer_id.numeric' => 'Customer value is wrong',
            'position_id.required' => 'Position can not empty',
            'position_id.numeric' => 'Position value is wrong',
            'city_id.required' => 'City can not empty',
            'city_id.numeric' => 'City value is wrong',
            'utm_campaign.required' => 'UTM Campaign can not empty',
            'utm_campaign.regex' => 'UTM Campaign value just can be alphabets and underscore',
            'utm_campaign.unique' => 'UTM Campaign have in database already',
            'ip_image.required_without' => 'Please choose an image',
            'ip_image.mimes' => 'File type is wrong',
            'ip_image.size' => 'File size is too big',
            'link.required' => 'Link can not empty',
            'link.active_url' => 'Link was die',
            'start_date.required' => 'Start date can not empty',
            'start_date.date_format' => 'Start date is wrong',
            'end_date.required' => 'End date can not empty',
            'end_date.date_format' => 'End date is wrong',
            'end_date.after_or_equal' => 'End date is wrong',
            'status.required' => 'Please choose status',
            'status.numeric' => 'Status is wrong'
        ];
    }
}
