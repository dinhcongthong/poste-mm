<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BullBoardRequest extends FormRequest
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
            'category_id'       => 'required|numeric',
            'name'              => 'required|string|max:191',
            'image1'            => 'nullable|image|mimes:jpg,jpeg,gif,png|max:2049',
            'image2'            => 'nullable|image|mimes:jpg,jpeg,gif,png|max:2049',
            'city_id'           => 'numeric',
            'address'           => 'required',
            'email'             => 'nullable|email|max:191',
            'show_phone_num'    => 'numeric|nullable',
            'accept'            => 'required|numeric',
            'start_date'        => 'nullable|date_format:Y-m-d',
            'end_date'          => 'nullable|date_format:Y-m-d|after_or_equal:start_date'
        ];
    }
    
    /**
    * Get the validation messages that apply to the request 
    * 
    * @return array 
    */
    public function messages() {
        return [
            'category_id.required'          => 'Please choose Product Category',
            'category_id.numeric'           => 'Product Category is wrong',
            'name.required'                 => 'Trading name is required',
            'name.string'                   => 'Trading name must be string',
            'name.max'                      => 'Trading name is too long',
            'image1.image'                  => 'Your file 1 you choose is not image',
            'image1.mimes'                  => 'Image 1 file type is wrong',
            'image1.max'                    => 'Image 1 file size is too large',
            'image2.image'                  => 'Your file 2 you choose is not image',
            'image2.mimes'                  => 'Image 2 file type is wrong',
            'image2.max'                    => 'Image 2 file size is too large',
            'city_id.numeric'               => 'City value is wrong',
            'address.required'              => 'Please enter address',
            'email.email'                   => 'Email is wrong',
            'email.max'                     => 'Email is too long',
            'show_phone_num.numeric'        => 'Please choose show phone option again',
            'accept.required'               => 'Please accept to term',
            'accept.numeric'                => 'Something is wrong',
            'start_date.date_format'        => 'Start date format is wrong',
            'end_date.date_format'          => 'End date format is wrong',
            'end_date.after_or_equal'       => 'End date is wrong',
        ];
    }
}
