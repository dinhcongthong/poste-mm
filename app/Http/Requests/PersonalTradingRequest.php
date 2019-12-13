<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalTradingRequest extends FormRequest
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
            'type_id'           => 'required|numeric',
            'category_id'       => 'required|numeric',
            'image1'            => 'nullable|image|mimes:jpg,jpeg,gif,png|max:2049',
            'image2'            => 'nullable|image|mimes:jpg,jpeg,gif,png|max:2049',
            'name'              => 'required|string|max:191',
            'price'             => 'required',
            'address'           => 'required|string|max:191',
            'delivery_id'       => 'numeric',
            'email'             => 'nullable|email|max:191',
            'show_phone_num'    => 'numeric|nullable',
            'accept'            =>  'required|numeric'
        ];
    }

    /**
     * Get the validation messages that apply to the request
     * 
     * @return array
     */
    public function messages() {
        return [
            'type_id.required'              => 'Please choose Trading Type',
            'type_id.numeric'               => 'Type value is wrong',
            'category_id.required'          => 'Please choose Product Category',
            'category_id.numeric'           => 'Product Category is wrong',
            'image1.image'                  => 'Your file 1 you choose is not image',
            'image1.mimes'                  => 'Image 1 file type is wrong',
            'image1.max'                    => 'Image 1 file size is too large',
            'image2.image'                  => 'Your file 2 you choose is not image',
            'image2.mimes'                  => 'Image 2 file type is wrong',
            'image2.max'                    => 'Image 2 file size is too large',
            'name.required'                 => 'Trading name is required',
            'name.string'                   => 'Trading name must be string',
            'name.max'                      => 'Trading name is too long',
            'address.required'              => 'Address is required',
            'address.string'                => 'Address must be string',
            'address.max'                   => 'Address is too long',
            'price.required'                => 'Price is required',
            'delivery_id.numeric'           => 'Delivery value is wrong',
            'email.email'                   => 'Email is wrong',
            'email.max'                     => 'Email is too long',
            'show_phone_num.numeric'        => 'Please choose show phone option again',
            'accept.required'               => 'Please accept to term',
            'accept.numeric'                => 'Something is wrong'
        ];
    }
}
