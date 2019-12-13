<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class BusinessGalleryRequest extends FormRequest
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
            'image_file' => 'required|image|mimes:jpg,png,gif,jpeg|max:2048|dimensions:min_width=400'
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
            'image_file.required'     => 'Please choose image',
            'image_file.mimes'  => 'Please check type of image',
            'image_file.max'    => 'Image too large',
            'image_file.dimensions' => 'Please custom width image'
        ];
    }
}
