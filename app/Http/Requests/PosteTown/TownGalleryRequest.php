<?php

namespace App\Http\Requests\PosteTown;

use Illuminate\Foundation\Http\FormRequest;

class TownGalleryRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpg,jpeg,png,svg,bmp,gif|max:2050'
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
            'image.required'        => 'Please choose Image',
            'image.image'           => 'File chosen not image',
            'image.mimes'           => 'File type is wrong',
            'image.max'             => 'Image File Size is too big'
        ];
    }
}
