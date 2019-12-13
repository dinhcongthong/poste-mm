<?php

namespace App\Http\Requests;

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
            'tag' => 'required',
            'fileImages.*' => 'required|mimes:jpg,jpeg,gif,png,bmp,svg|max:2049'
        ];
    }

    /**
     * Get the validation messages that apply to the request
     * 
     * @return array
     */
    public function messages() {
        return [
            'tag.required' => 'Please choose tag',
            'fileImages.*.required' => 'Please select image',
            'fileImages.*.mimes' => 'Image file type is wrong',
            'fileImages.*.max' => 'Image size too large'
        ];
    }
}
