<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
            'tag' => 'required|numeric',
            'order_num' => 'required',
            'icon' => 'nullable|mimes:jpg,png,jpeg,svg|max:3702|dimensions:ratio=1',
            'parent_id' => 'required|numeric'
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
            'tag.required' => 'Tag can not empty',
            'tag.numeric' => 'Tag value is wrong',
            'order_num.required' => 'Order number can not empty',
            'icon.mimes' => 'File type is wrong',
            'icon.max' => 'File size too large',
            'icon.dimensions' => 'Dimension image is wrong. It should be 1x1',
            'parent_id.required' => 'Please choose parent category',
            'parent_id.numeric' => 'Parent category value is wrong'
        ];
    }
}
