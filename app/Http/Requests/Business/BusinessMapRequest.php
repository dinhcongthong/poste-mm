<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class BusinessMapRequest extends FormRequest
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
            'address'  => 'required',
            'map'   => 'nullable',
            'route_guide'   => 'nullable',
            'image_route_guide' => 'nullable|image|mimes:jpg,png,gif,jpeg|max:2048|dimensions:min_width=400'
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
            'address.required'  => 'Please input address',
            'image_route_guide.mimes'  => 'Please check type of image',
            'image_route_guide.max'    => 'Image too large',
            'image_route_guide.dimensions' => 'Please custom width image'
        ];
    }
}
