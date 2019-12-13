<?php

namespace App\Http\Requests\PosteTown;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
            'images.*'      => 'required|mimes:jpg,jpeg,png|max:2049',
            'type'          => 'required|numeric',
            'town_id'       => 'required|numeric',
        ];
    }
    
    /**
    * Get the validation messages that apply to the request
    * 
    * @return array
    */
    public function messages() {
        return [
            'image.required' => 'Please choose image',
            'image.mimes'    => 'Image you choose have wrong extension',
            'image.max'      => 'Image you choose have size too large',
            'type.required'     => 'Album have error',
            'type.numeric'      => 'Album have error',
            'town_id.required'  => 'Town ID have error',
            'town_id.numeric'  => 'Town ID have error'
        ];
    }
}
